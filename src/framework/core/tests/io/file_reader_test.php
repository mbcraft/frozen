<?php

class TestFileReader extends UnitTestCase
{
    function testReader1()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/myfile_01.txt");
        try
        {
            $reader = $f->openReader();
            $this->assertTrue($reader instanceof FileReader,"L'oggetto non e' del tipo specificato!!");

            $this->assertTrue($reader->isOpen(),"Il reader non e' aperto!!");
            $reader->close();
            $this->assertFalse($reader->isOpen(),"Il reader non e' stato chiuso!!");
        }
        catch (Exception $ex)
        {
            $this->fail("Errore nell'apertura del reader di un file esistente!!");
        }

    }

    function testReader2()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/non_existent_file.txt");

        $this->assertFalse($f->exists(),"Il file esiste!!");
        $this->expectException("IllegalStateException");
        $reader = $f->openReader();

    }

    function testReaderScanf()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/scanf_test.txt");

        $reader = $f->openReader();

        $result = $reader->scanf("%2d %2d %s");
        $result2 = $reader->scanf("age:%d weight:%dkg");

        $this->assertEqual($result[0],12,"Il valore letto non è 12!!");
        $this->assertEqual($result[1],44,"Il valore letto non è 44!!");
        $this->assertEqual($result[2],"John","Il valore letto non è John!!");

        $this->assertEqual($result2[0],30,"Il valore letto non e' 30!! : ".$result2[0]);
        $this->assertEqual($result2[1],60,"Il valore letto non e' 60!! : ".$result2[1]);

    }

    function testReaderSeek()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/scanf_test.txt");

        $reader = $f->openReader();

        $result = $reader->scanf("%2d %2d %s");
        $reader->seek(0);

        $this->assertEqual($reader->pos(),0,"La posizione non e' tornata zero dopo seek(0)!!!");

        $result2 = $reader->scanf("%2d %2d %s");

        $this->assertEqual($result[0],$result2[0],"I valori letti non corrispondono!!");
        $this->assertEqual($result[1],$result2[1],"I valori letti non corrispondono!!");
        $this->assertEqual($result[2],$result2[2],"I valori letti non corrispondono!!");

    }

    function testWriterSeek()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/reader_writer/printf_test.txt");

        $writer = $f->openWriter();

        $writer->printf("%2d %2d %2d",12,34,56);
        $writer->reset();

        $this->assertEqual($writer->pos(),0,"La posizione non e' tornata zero dopo seek(0)!!!");

        $writer->printf("%2d",99);

        $writer->reset();

        $this->assertEqual($writer->pos(),0,"La posizione non e' corretta dopo la seek del writer : ".$writer->pos());

        $result = $writer->scanf("%2d %2d %2d");

        $this->assertEqual($result[0],99,"I valori letti non corrispondono!! : ".$result[0]);
        $this->assertEqual($result[1],34,"I valori letti non corrispondono!! : ".$result[1]);
        $this->assertEqual($result[2],56,"I valori letti non corrispondono!! : ".$result[2]);

    }

}

?>