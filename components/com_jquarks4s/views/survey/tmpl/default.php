<?php
    defined('_JEXEC') or die('restricted access');

    global $mainframe;

    $jq   = JRoute::_("components/com_jquarks4s/assets/js/validate/lib/jquery.js");
    $vld  = JRoute::_("components/com_jquarks4s/assets/js/validate/lib/jquery.metadata.js");
    $meta = JRoute::_("components/com_jquarks4s/assets/js/validate/jquery.validate.js");
    $tag = '<script src="'.$jq.'" type="text/javascript"></script>
            <script src="'.$meta.'" type="text/javascript"></script>
            <script src="'.$vld.'" type="text/javascript"></script>';
    $mainframe->addCustomHeadTag($tag);
    $mainframe->addCustomHeadTag('<link rel="stylesheet" href="'.$this->baseurl.'/components/com_jquarks4s/assets/css/survey.css" type="text/css" />');

    JHTML::_('behavior.formvalidation');

$vld_tag = 'class="{required:true}"';

$headerDisplayed = false;
$sectionId    = null;
$questionId   = null;

$footer = null;

$questionNbr = 0;

$arrayRows = array();
$arrayColumns = array();

$is_previous_question_matrix = false;

// To get the RFP ID from URL anil 22-07-2011
$rfp = JRequest::getVar('rfp','','get','' );
$surveyid = JRequest::getVar('id','','get','' );
//$rfp = JRequest::getVar('rfp','','get','' );
//echo $rfp; exit;
//echo $surveyid; exit;

// end RFP ID from URL anil 22-07-2011
?>
<br /><br />
<div id="i_bar">
<div id="i_icon"><a href="index2.php?option=com_content&amp;view=article&amp;id=234&amp;Itemid=113" rel="{handler: 'iframe', size: {x: 680, y: 530}}" class="modal" title="Click here" style="text-decoration: none;"><img src="templates/camassistant_left/images/info_icon2.png"> </a>
</div>
    <div id="i_bar_txt">
<span><font style="font-weight:bold;">&nbsp;&nbsp;Please give us your opinion on vendors for your awarded RFPs </font>(Opinion on Vendor)</span>
</div></div>
<?php


if ($this->rows): // if survey exists
    foreach ($this->rows as $rowKey => $row):

?>
<script type="text/javascript">

  jQuery(document).ready(function($) {
    $.validator.setDefaults(
        {

        }
    );
    $("#jq4s_srvy_frm").validate(
        {
            errorContainer: $('div.jq4s_warning')
        }
    );
  });

</script>

<form id="jq4s_srvy_frm" name="jquarks4s_survey" method="post" action="index.php">

<!-- HEADER -->
<?php
        if ( ! $headerDisplayed) :
            $headerDisplayed = true;
?>
<!-- SURVEY TITLE -->
<div class="componentheading">
    <h2><?php //echo $row->title; ?></h2>
</div>
<!-- SURVEY DESCRIPTION -->
<div class="contentdescription">
    <?php echo $row->description; ?>
</div>
<?php endif; ?>

<!-- BODY -->

    <!-- SECTION -->
<?php
        if ($sectionId != $row->section_id) : // if new section
            $sectionId = $row->section_id;
            $questionNbr = 0;
?>
<!--<h4>-->
<!-- section title -->
    <?php //echo nl2br($row->section_name); ?>  
<!-- end section title -->	
<!--</h4>-->
<?php endif; ?>

    <!-- QUESTION -->
        <!-- MATRIX PREVIOUS QUESTION -->
<?php

    if ($questionId != $row->question_id && ! is_null($row->question_id)) :  // if new question

            $previousQuestionId = $questionId;
            $questionId = $row->question_id;

            $questionNbr++;

            if ($is_previous_question_matrix) // display matrix of previous question
            {
                $nbrl = count($arrayRows);
                $nbrc = count($arrayColumns);

                reset($arrayRows);
                reset($arrayColumns);
                $fields = '<table style="margin-left:10px;" border="1">';
                if ($row->is_compulsory) {
                    $vld_table = $vld_tag;
                } else {
                    $vld_table = '';
                }
                for ($i = -1; $i < $nbrl; $i++)
                {
                    if ($i != -1) {
                        $currentRow = each($arrayRows);
                    }
                    $fields .= '<tr>';
                    for ($j = -1; $j < $nbrc; $j++)
                    {
                        if ($i == -1)
                        {
                            if ($j == -1) { //remplissage des colonnes
                                $fields .= '<td></td>';
                            }
                            else {
                                $currentColumn = each($arrayColumns);
                                $fields .= '<td>' . $currentColumn['value'] . '</td>';
                            }
                        }
                        else
                        {
                            if ($j == -1) {
                                $fields .= '<td>' . $currentRow['value'] . '</td>';
                            }
                            else {
                                $currentColumn = each($arrayColumns);
                                $fields .= '<td><input '.$vld_table.' type="radio" value="'. $currentColumn['key'] .'" name="q['. $previousQuestionId .']['. $currentRow['key'] .']" /></td>';
                            }

                        }

                    }
                    reset($arrayColumns);
                    $fields .= '</tr>';
                }
                $fields .= '</table>';

                echo $fields;
            }

            $arrayRows = array();
            $arrayColumns = array();
            $is_previous_question_matrix = false;
?>
    <!-- QUESTION STATEMENT -->
<?php if ($row->is_compulsory): ?>
    <div class="jq4s_warning"><?php echo "Please answer to this question."; ?></div>
<?php endif; ?>
<div class="question_statement">
    <ol style="padding-left: 20px;">
        <li value="<?php echo $questionNbr ?>"><?php echo $row->statement ?></li>
        <?php echo ( ! $row->is_compulsory) ? '<i>( '.JText::_('OPTIONAL').' )</i>' : ''; ?>
    </ol>
</div>
<?php endif; ?>

        <!-- PROPOSITIONS -->
<?php
switch ($row->type_id) :
    case 1: // text
	$quesid = $row->question_id;  /* to find the question id */
	// To Auto fill the RFP ID in the 1st question from the urlid
	if($surveyid == '1' && $quesid == '1') { 
        ?>
		<textarea <?php echo ($row->is_compulsory)? $vld_tag: ''; ?>
                  style="margin-left:20px;"
                  cols="20" rows="1"
                  size="50"
                  name="q[<?php echo $row->question_id; ?>][answer]"
                  value="" readonly="readonly" ><?php echo $rfp; ?></textarea>
        <input type="hidden" name="q[<?php echo $row->question_id; ?>][type_id]" value="1" />
		<?php } else { ?>
        <textarea <?php echo ($row->is_compulsory)? $vld_tag: ''; ?>
                  style="margin-left:20px;"
                  cols="40" rows="3"
                  size="50"
                  name="q[<?php echo $row->question_id; ?>][answer]"
                  value="" ></textarea>
        <input type="hidden" name="q[<?php echo $row->question_id; ?>][type_id]" value="1" />
        <?php }
        break;

    case 2: //single choice
        ?>
        <input <?php echo ($row->is_compulsory)? $vld_tag: ''; ?> style="margin-left:10px;" type="radio"
               name="q[<?php echo $row->question_id; ?>][proposition]"
               value="<?php echo $row->proposition_id; ?>" />
        <input type="hidden" name="q[<?php echo $row->question_id; ?>][type_id]" value="2" />
        <?php echo nl2br($row->proposition); ?>
        <br />
        <?php
        if ($row->is_text_field):
        ?>
        <input style="margin-left:25px;"
               type="text"
               name="qp_field[<?php echo $row->question_id; ?>][<?php echo $row->proposition_id; ?>]"
               value="" />
        <input type="hidden"
               name="q[<?php echo $row->question_id; ?>][<?php echo $row->proposition_id; ?>][is_text_field]"
               value="1" />
        <br />
        <?php
        endif;
        break;

    case 3: // multiple choice
        ?>
        <input <?php echo ($row->is_compulsory)? $vld_tag: ''; ?>
               style="margin-left:10px;" type="checkbox"
               name="q[<?php echo $row->question_id; ?>][proposition][]"
               value="<?php echo $row->proposition_id; ?>" />
        <input type="hidden" name="q[<?php echo $row->question_id; ?>][type_id]" value="3" />
        <?php echo nl2br($row->proposition); ?>
        <br />
        <?php
        if ($row->is_text_field):
        ?>
        <input style="margin-left:25px;"
               type="text"
               name="qp_field[<?php echo $row->question_id; ?>][<?php echo $row->proposition_id; ?>]"
               value="" />
        <input type="hidden"
               name="q[<?php echo $row->question_id; ?>][<?php echo $row->proposition_id; ?>][is_text_field]"
               value="1" />
        <br />
        <?php
        endif;
        break;

    case 4: //matrix
        ?>
        <input type="hidden" name="q[<?php echo $row->question_id; ?>][type_id]" value="4" />
        <?php

        $is_previous_question_matrix = true;
        if ( ! is_null($row->row_id)) {
            $arrayRows[$row->row_id] = $row->row_title;
        }
        if ( ! is_null($row->column_id)) {
            $arrayColumns[$row->column_id] = $row->column_title;
        }

        // display html table if only 1 question in the survey with matrix type
        if ( 4 == (int)$row->type_id  && $rowKey == (count($this->rows)-1) ) :
            //TO DELETE : && $this->nbrQuestions == 1
                $nbrl = count($arrayRows);
                $nbrc = count($arrayColumns);

                reset($arrayRows);
                reset($arrayColumns);
                $fields = '<table style="margin-left:10px;" border="1">';
                if ($row->is_compulsory) {
                    $vld_table = $vld_tag;
                } else {
                    $vld_table = '';
                }
                for ($i = -1; $i < $nbrl; $i++)
                {
                    if ($i != -1) {
                        $currentRow = each($arrayRows);
                    }
                    $fields .= '<tr>';
                    for ($j = -1; $j < $nbrc; $j++)
                    {
                        if ($i == -1)
                        {
                            if ($j == -1) { //remplissage des colonnes
                                $fields .= '<td></td>';
                            }
                            else {
                                $currentColumn = each($arrayColumns);
                                $fields .= '<td>' . $currentColumn['value'] . '</td>';
                            }
                        }
                        else
                        {
                            if ($j == -1) {
                                $fields .= '<td>' . $currentRow['value'] . '</td>';
                            }
                            else {
                                $currentColumn = each($arrayColumns);
                                $fields .= '<td><input '.$vld_table.' type="radio" value="'. $currentColumn['key'] .'" name="q['. $row->question_id .']['. $currentRow['key'] .']" /></td>';
                            }

                        }

                    }
                    reset($arrayColumns);
                    $fields .= '</tr>';
                }
                $fields .= '</table>';

                echo $fields;

        endif;


endswitch;
?>


<?php
    if ( ! $footer) {
        $footer = $row->footer;
    }

    endforeach;

?>

<!-- FOOTER -->
<br /><br />
<div>
    <input class="button" type="submit" value="<?php //echo JText::_('SUBMIT_ANSWERS'); ?>" id="submitsurvyform"  />
</div>
<!-- FOOTER -->
<br />
<div>
<?php
    echo $footer;
?>
</div>

<br /><br />

<input type="hidden" name="option"     value="com_jquarks4s" />
<!--<input type="hidden" name="controller" value="jquarks4s" />  /* value="jquarks4s" is replaced with value="Survey" as we upgrade from versio 1.1.1 to 1.1.2 */ --> 
<input type="hidden" name="controller" value="survey" />
<input type="hidden" name="task"       value="submitSurvey" />
<input type="hidden" name="survey_id"  value="<?php echo $this->survey_id ; ?>"/>
<input type="hidden" name="user_id"    value="<?php echo $this->user_id ; ?>"/>
<input type="hidden" name="rfpid"    value="<?php echo $_REQUEST['rfp']; ?>"/>
<input type="hidden" name="ip_address" value="<?php echo $_SERVER["REMOTE_ADDR"]; ?>"/>
<?php echo JHTML::_( 'form.token' );  ?>
</form>

<!-- JQUARKS footer -->
<div>
    <!--<a href="http://www.jquarks.org" target="_blank">Powered by JQuarks</a>-->
</div>

<?php
else:
    echo JText::_('ERROR_NO_AVAILABLE_SURVEY');
endif;

