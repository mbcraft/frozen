<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class TestTextEditor extends UnitTestCase
{
    function testBasicTextEditor()
    {
        $content = "12345AAAAAAAAA6789";
        
        $te = new TextEditor();
        $te->set_content($content);
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero di modifiche non è zero alla creazione del TextEditor!!");
        
        $te->push_change(5, 9, "");
        
        $this->assertEqual(1,$te->get_changes_count(),"La modifica non e' stata conteggiata!!");
        
        $this->assertEqual($te->preview_changes(),"123456789","I cambiamenti effettuati non corrispondono!! Atteso : '123456789' Trovato : ".$te->preview_changes());
    
        $this->assertEqual($te->get_content(),$content,"Il contenuto e' stato modificato dopo l'inserimento della modifica!!");
        
        $te->apply_changes();
        
        $this->assertEqual("123456789",$te->get_content(),"Il contenuto non e' stato aggiornato correttamente!!");
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero delle modifiche non e' stato resettato!!");
        
    }
    
    function testBasicTextEditor2()
    {
        $content = "123456789";
        
        $te = new TextEditor();
        $te->set_content($content);
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero di modifiche non è zero alla creazione del TextEditor!!");
        
        $te->push_change(0, 0, "0");
        
        $this->assertEqual(1,$te->get_changes_count(),"La modifica non e' stata conteggiata!!");
        
        $this->assertEqual($te->preview_changes(),"0123456789","I cambiamenti effettuati non corrispondono!! Atteso : '123456789' Trovato : ".$te->preview_changes());
    
        $this->assertEqual($te->get_content(),$content,"Il contenuto e' stato modificato dopo l'inserimento della modifica!!");
        
        $te->apply_changes();
        
        $this->assertEqual("0123456789",$te->get_content(),"Il contenuto non e' stato aggiornato correttamente!!");
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero delle modifiche non e' stato resettato!!");
    
    }
    
    function testReplace()
    {
        $content = "123456789";
        
        $te = new TextEditor();
        $te->set_content($content);
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero di modifiche non è zero alla creazione del TextEditor!!");
        
        $te->replace(2,3, "AAA");
        
        $this->assertEqual(1,$te->get_changes_count(),"La modifica non e' stata conteggiata!!");
        
        $this->assertEqual($te->preview_changes(),"12AAA456789","I cambiamenti effettuati non corrispondono!! Atteso : '123456789' Trovato : ".$te->preview_changes());
    
        $this->assertEqual($te->get_content(),$content,"Il contenuto e' stato modificato dopo l'inserimento della modifica!!");
        
        $te->apply_changes();
        
        $this->assertEqual("12AAA456789",$te->get_content(),"Il contenuto non e' stato aggiornato correttamente!!");
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero delle modifiche non e' stato resettato!!");

    }
    
    function testInsertDelete()
    {
        $content = "123456789";
        
        $te = new TextEditor();
        $te->set_content($content);
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero di modifiche non è zero alla creazione del TextEditor!!");
        
        $te->insert(0, "0");
        
        $this->assertEqual(1,$te->get_changes_count(),"La modifica non e' stata conteggiata!!");
        
        $this->assertEqual($te->preview_changes(),"0123456789","I cambiamenti effettuati non corrispondono!! Atteso : '123456789' Trovato : ".$te->preview_changes());
    
        $this->assertEqual($te->get_content(),$content,"Il contenuto e' stato modificato dopo l'inserimento della modifica!!");
        
        $te->apply_changes();
        
        $this->assertEqual("0123456789",$te->get_content(),"Il contenuto non e' stato aggiornato correttamente!!");
        
        $this->assertEqual(0,$te->get_changes_count(),"Il numero delle modifiche non e' stato resettato!!");
    
        $te->delete(5,1);
        
        $te->apply_changes();
        
        $this->assertEqual($te->get_content(),"012346789","Il contenuto eliminato non corrisponde!!");
    }
}

