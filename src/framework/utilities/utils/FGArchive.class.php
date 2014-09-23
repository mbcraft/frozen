<?
/* This software is released under the BSD license. Full text at project root -> license.txt */


/*
 * FORMATO DEL FILE
 *
 *
 * FGA -> 3 bytes
 * (major_version) -> 2 bytes
 * (minor_version) -> 2 bytes
 * (revision) -> 2 bytes
 * (num_files) -> 2 bytes
 *
 * per ogni file
 *
 * (path_length) -> 2 bytes
 * (path) -> path_length bytes
 * (size) -> 4 bytes
 * (file_data) -> size bytes
 * */
class FGArchive
{
    const FG_ARCHIVE_HEADER = "FGA";

    const CURRENT_MAJOR = 0;
    const CURRENT_MINOR = 1;
    const CURRENT_REV = 1;

    const ENTRY_TYPE_DIR = 1;
    const ENTRY_TYPE_FILE = 2;

    static function extract($f,$dir)
    {
        $reader = $f->openReader();
        $binarydata = $reader->read(3);
        $data = unpack("a3",$binarydata);

        if ($data[1]!==self::FG_ARCHIVE_HEADER) throw new InvalidDataException("Intestazione del file non valida : ".$data[1]);

        $binarydata = $reader->read(2+2+2);
        $data = unpack("v3",$binarydata);

        if ($data[1]!==self::CURRENT_MAJOR || $data[2]!==self::CURRENT_MINOR || $data[3]!==self::CURRENT_REV) throw new InvalidDataException("Versione del file non supportata!! : ".$data[1]."-".$data[2]."-".$data[3]);

        $binarydata = $reader->read(2);
        $data = unpack("v",$binarydata);
        $num_entries = $data[1];

        $i = 0;
        while ($i < $num_entries)
        {
            $binarydata = $reader->read(2);
            $data = unpack("v",$binarydata);
            $entry_type = $data[1];


            $binarydata = $reader->read(2);
            $data = unpack("v",$binarydata);
            $path_length = $data[1];

            $binarydata = $reader->read($path_length);
            $data = unpack("a*",$binarydata);
            $path = $data[1];

            if ($entry_type===self::ENTRY_TYPE_DIR)
            {
                $d = $dir->newSubdir($path);
                $d->touch();
            }
            if ($entry_type===self::ENTRY_TYPE_FILE)
            {
                $binarydata = $reader->read(4);
                $data = unpack("V",$binarydata);
                $num_bytes = $data[1];

                $compressed_file_data = $reader->read($num_bytes);
                $uncompressed_file_data = gzuncompress($compressed_file_data);

                $f = new File($dir->getPath().$path);
                $writer = $f->openWriter();
                $writer->write($uncompressed_file_data);
                $writer->close();

                $sha1_checksum = $reader->read(20);
                if (strcmp($sha1_checksum,sha1_file($f->getFullPath(),true))!==0)
                   throw new InvalidDataException("La somma sha1 non corrisponde per il file : ".$f->getPath());
            }
            $i++;
        }

        $reader->close();

    }

    private static function __recursive_compress_dir($writer,$root_dir,$dir)
    {
        $path = $dir->getPath($root_dir);

        $binarydata = pack("v",self::ENTRY_TYPE_DIR);
        $writer->write($binarydata);

        //write path length
        $binarydata = pack("v",strlen($path));
        $writer->write($binarydata);

        //write path
        $binarydata = pack("a*",$path);
        $writer->write($binarydata);

        $total_entries = 1;

        $all_files = $dir->listFiles();

        foreach ($all_files as $f)
        {
            if ($f->isFile())
            {
                $total_entries +=1;

                $binarydata = pack("v",self::ENTRY_TYPE_FILE);
                $writer->write($binarydata);

                $path = $f->getPath($root_dir);

                //write path length
                $binarydata = pack("v",strlen($path));
                $writer->write($binarydata);

                //write path
                $binarydata = pack("a*",$path);
                $writer->write($binarydata);

                $uncompressed_file_data = $f->getContent();
                $compressed_file_data = gzcompress($uncompressed_file_data,9);

                $size = strlen($compressed_file_data);

                $binarydata = pack("V",$size);

                $writer->write($binarydata);
                $writer->write($compressed_file_data);

                //20 bytes
                $writer->write(sha1_file($f->getFullPath(),true));
            }

            if ($f->isDir())
            {
                $total_entries += self::__recursive_compress_dir($writer,$root_dir,$f);
            }
        }

        return $total_entries;

    }

    static function compress($target_file,$root_dir)
    {
        $writer = $target_file->openWriter();
        $binarydata = pack("a3",self::FG_ARCHIVE_HEADER);
        $writer->write($binarydata);
        $binarydata = pack("v3",self::CURRENT_MAJOR,self::CURRENT_MINOR,self::CURRENT_REV);
        $writer->write($binarydata);

        $metadata_pos = $writer->pos();

        //num_entries
        $binarydata = pack("v",0);
        $writer->write($binarydata);

        $total_entries = self::__recursive_compress_dir($writer,$root_dir,$root_dir);

        $writer->seek($metadata_pos);
        $binarydata = pack("v",$total_entries);
        $writer->write($binarydata);

        $writer->close();

    }
}

?>