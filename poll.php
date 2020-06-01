<?php

$vote = $_REQUEST['vote'];

$file = 'pollResult.txt';
$resultsText = file();

$resultsArray = explode(',', $resultsText[0]);

$renaissance = $resultsArray[0];
$baroque = $resultsArray[1];
$classical = $resultsArray[2];
$romantic = $resultsArray[3];
$twentieth = $resultsArray[4];

switch ($vote)
{
    case 0:
        $renaissance += 1;
        break;
    case 1:
        $baroque += 1;
        break;
    case 2:
        $classical += 1;
        break;
    case 3:
        $romantic += 1;
        break;
    case 4:
        $twentieth += 1;
        break;
}

$insertVote = $renaissance.','.$baroque.','.$classical.','.$romantic.','.$twentieth;
$fp = fopen($file, "w");
fputs($fp, $insertVote);
fclose($fp);
?>

<h2>Result:</h2>
<table>
    <tr>
        <td>Renaissance:</td>
        <td class="resultBar" style="width:<?php round($renaissance/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%">
        <?php round($renaissance/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%
        </td>
        <td>Baroque:</td>
        <td class="resultBar" style="width:<?php round($baroque/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%">
        <?php round($baroque/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%
        </td>
        <td>Classical:</td>
        <td class="resultBar" style="width:<?php round($classical/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%">
        <?php round($classical/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%
        </td>
        <td>Romantic:</td>
        <td class="resultBar" style="width:<?php round($romantic/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%">
        <?php round($romantic/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%
        </td>
        <td>Twentieth Century:</td>
        <td class="resultBar" style="width:<?php round($twentieth/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%">
        <?php round($twentieth/($renaissance+$baroque+$classical+$romantic+$twentieth)*100, 2);?>%
        </td>
    </tr>
</table>