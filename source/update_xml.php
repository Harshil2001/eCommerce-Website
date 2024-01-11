<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $xmlString = file_get_contents('php://input');
    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;
    $doc->loadXML($xmlString);
    $prettyXmlString = $doc->saveXML();
    file_put_contents('inventory.xml', $prettyXmlString);
    echo json_encode(['status' => 'success', 'message' => 'XML Inventory updated']);
}
?>
