<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestFileWriter extends UnitTestCase
{
    function testWriterOpenButDontChange()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/myfile_01.txt");

        $this->assertEqual(24,$f->getSize(),"La dimensione del file non corrisponde!! : ".$f->getSize());

        try
        {
            $writer = $f->openWriter();
            $this->assertTrue($writer instanceof FileWriter,"L'oggetto non e' del tipo specificato!!");

            $this->assertTrue($writer->isOpen(),"Il writer non e' aperto!!");
            $writer->close();
            $this->assertFalse($writer->isOpen(),"Il writer non e' stato chiuso!!");
        }
        catch (Exception $ex)
        {
            $this->fail("Errore nell'apertura del writer di un file esistente!!");
        }

    }

    function testWriterCreateIfNotExists()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/blablabla.txt");
        $this->assertFalse($f->exists(),"Il file esiste gia'!!");
        try
        {
            $writer = $f->openWriter();
            $this->assertTrue($f->exists(),"Il file non e' stato creato!!");

            $this->assertTrue($writer instanceof FileWriter,"L'oggetto non e' del tipo specificato!!");

            $this->assertTrue($writer->isOpen(),"Il writer non e' aperto!!");
            $writer->close();
            $this->assertFalse($writer->isOpen(),"Il writer non e' stato chiuso!!");
        }
        catch (Exception $ex)
        {
            $this->fail("Errore nell'apertura del writer di un file non esistente!!");
        }
        $f->delete();

    }

    function testBasicWritelnThenReadln()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/readwrite.txt");
        $this->assertFalse($f->exists(),"Il file esiste gia'!!");
        try
        {
            $writer = $f->openWriter();
            $this->assertTrue($f->exists(),"Il file non e' stato creato!!");

            $this->assertTrue($writer instanceof FileWriter,"L'oggetto non e' del tipo specificato!!");

            $this->assertTrue($writer->isOpen(),"Il writer non e' aperto!!");

            $writer->writeln("Ciao mondo!!!");
            $writer->writeln("Hello!!");

            $writer->close();

            $reader = $f->openReader();
            $first_line = $reader->readLine();
            $this->assertEqual(strlen("Ciao mondo!!!"),strlen($first_line),"La lunghezza attesa non corrisponde!! : ".strlen($first_line));
            $this->assertEqual("Ciao mondo!!!",$first_line,"Il dato letto non corrisponde!! :".$first_line);
            $second_line = $reader->readLine();
            $this->assertEqual(strlen("Hello!!"),strlen($second_line),"La lunghezza attesa non corrisponde!! : ".strlen($second_line));
            $this->assertEqual("Hello!!",$second_line,"Il dato letto non corrisponde!! :".$second_line);

            $reader->close();
        }
        catch (Exception $ex)
        {
            $this->fail("Errore nell'apertura del writer di un file non esistente!!");
        }
        $f->delete();
    }

    function testAdvancedPrintfWriteThenRead()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/readwrite2.txt");
        $this->assertFalse($f->exists(),"Il file esiste gia'!!");
        try
        {
            $writer = $f->openWriter();
            $this->assertTrue($f->exists(),"Il file non e' stato creato!!");

            $this->assertTrue($writer instanceof FileWriter,"L'oggetto non e' del tipo specificato!!");

            $this->assertTrue($writer->isOpen(),"Il writer non e' aperto!!");

            $writer->write("Ciao mondo!!!");
            $writer->printf(" %02d %02d go",12,34);

            $writer->close();

            $reader = $f->openReader();
            $line = $reader->read(22);
            $this->assertEqual("Ciao mondo!!! 12 34 go",$line,"I dati letti non corrispondono!! : ".$line);

            $reader->close();
        }
        catch (Exception $ex)
        {
            $this->fail("Errore nell'apertura del writer di un file non esistente!!");
        }
        $f->delete();
    }

    function testCreateTmpFile()
    {
        $fw = FileWriter::newTmpFile();

        $this->assertTrue($fw->isOpen(),"Il file temporaneo non risulta aperto!!");

        $fw->writeln("Ciao, questo e' un file temporaneo...");
        $fw->reset();

        $line = $fw->readLine();

        $this->assertEqual("Ciao, questo e' un file temporaneo...",$line,"Il dato letto dal file temporaneo non corrisponde!!");

        $fw->close();
    }

    function testExceptionAfterCloseOnRead()
    {
        $fw = FileWriter::newTmpFile();

        $this->assertTrue($fw->isOpen(),"Il file temporaneo non risulta aperto!!");

        $fw->writeln("Ciao, questo e' un file temporaneo...");
        $fw->reset();

        $fw->close();

        $this->expectException("IllegalStateException");
        $line = $fw->readLine();
    }

    function testExceptionAfterCloseOnWrite()
    {
        $fw = FileWriter::newTmpFile();

        $this->assertTrue($fw->isOpen(),"Il file temporaneo non risulta aperto!!");

        $fw->writeln("Ciao, questo e' un file temporaneo...");
        $fw->reset();

        $fw->close();

        $this->expectException("IllegalStateException");
        $line = $fw->writeln("Ciao!!");
    }



}

?>