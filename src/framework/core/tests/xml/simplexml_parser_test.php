<?php
/*
 * NOTA DI COPYRIGHT
Questo framework è esclusiva proprietà di Frostlab gate. Ne è vietato l'utilizzo, la copia, la modifica o la redistribuzione 
sotto qualsiasi forma senza l'esplicito consenso da parte di Frostlab gate. Tutti i diritti riservati.
 *
 * COPYRIGHT NOTICE
This framework is exclusive property of Frostlab gate. Usage, copy, changes or redistribution in any form are forbidden
without an explicit agreement with Frostlab gate. All rights reserved.
 */

class TextXmlParser extends UnitTestCase
{
    function getXML()
    {
      $xml = <<<END_OF_DATA
<?xml version="1.0" encoding="UTF-8"?> 
    <GetSellerListResponse xmlns="urn:ebay:apis:eBLBaseComponents">
    <Timestamp>2010-03-29T12:40:59.517Z</Timestamp>
    <Ack>Success</Ack>
    <Version>659</Version>
    <Build>E659_INTL_BUNDLED_10855434_R1</Build>
    <PaginationResult>
        <TotalNumberOfEntries>4</TotalNumberOfEntries>
    </PaginationResult>
    <ItemArray>
        <Item>
            <ItemID>110044392239</ItemID>
            <ListingDetails>
                <StartTime>2010-03-24T17:42:01.000Z</StartTime>
                <EndTime>2010-03-29T17:42:01.000Z</EndTime>
            </ListingDetails>
        </Item>
        <Item>
            <ItemID>110044414366</ItemID>
            <ListingDetails>
                <StartTime>2010-03-25T14:58:07.000Z</StartTime>
                <EndTime>2010-04-24T14:58:07.000Z</EndTime>
            </ListingDetails>
        </Item>
        <Item>
            <ItemID>110044414402</ItemID>
            <ListingDetails>
                <StartTime>2010-03-25T15:00:17.000Z</StartTime>
                <EndTime>2010-04-04T15:00:17.000Z</EndTime>
            </ListingDetails>
        </Item>
        <Item>
            <ItemID>110044414597</ItemID>
            <ListingDetails>
                <StartTime>2010-03-25T15:04:17.000Z</StartTime>
                <EndTime>2010-04-24T15:04:17.000Z</EndTime>
            </ListingDetails>
        </Item>
    </ItemArray>
    <ReturnedItemCountActual>4</ReturnedItemCountActual>
</GetSellerListResponse>
END_OF_DATA;
        return $xml;
    }

    public function testXMLParsingWithSimpleXML()
    {
        $parser = new SimpleXMLElement($this->getXML());
        $this->assertEqual($parser->Version,"659","La versione non corrisponde!");
        $this->assertEqual($parser->Ack,"Success","Il campo ack non corrisponde!");
        $this->assertEqual($parser->PaginationResult->TotalNumberOfEntries,"4","Numero delle entries non corrisponde!");
        $this->assertEqual($parser->ItemArray->Item[0]->ItemID,"110044392239","Numero del primo item non corrisponde!");
        $this->assertEqual($parser->Pluto,"","Elemento che non esiste non vuoto!");
    }

}

