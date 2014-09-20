<?
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestMoneyValue extends UnitTestCase
{
    function testMoneyAddPercentage()
    {
        $a = new MoneyValue(100);
        $a->add_percentage(0.21);
        
        $this->assertEqual(121,$a->get_value(),"La percentuale non e' stata aggiunta correttamente!!");
    }
    
    function testMoneyRemovePercentage()
    {
        $a = new MoneyValue(121);
        $a->remove_percentage(0.21);
        
        $this->assertEqual(100,$a->get_value(),"La percentuale non e' stata sottratta correttamente!!");
    }
}

?>