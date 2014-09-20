<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


/*
 * Non posso chiamare la funzione testRedirects altrimenti il tester mi va in errore :/
 */

class TestRedirect extends UnitTestCase
{
    function testGetSetAndNotFound()
    {
        Redirect::set_with_key("after_utente_save", "/utenti/index.php");

        $this->assertEqual(Redirect::get_by_key("after_utente_save")->getUrl(),"/utenti/index.php");


        try
        {
            $this->assertEqual(Redirect::get_by_key("blabla"),"");
            $this->fail("Non viene lanciata nessuna eccezione se il redirects not found non è presente!!!");
        }
        catch (Exception $ex)
        {

        }

        Redirect::set_with_key(Redirect::REDIRECT_NOT_FOUND, "/errors/redirect_not_found.php");

        try
        {
            $this->assertEqual(Redirect::get_by_key("blabla")->getUrl(),"/errors/redirect_not_found.php");
        }
        catch (Exception $ex)
        {
            $this->fail("Viene lanciata un'eccezione dopo aver definito il REDIRECT_NOT_FOUND!!!");
        }

        $this->assertTrue(Redirect::get_by_key("blabla") instanceof Redirect);
    }
}

