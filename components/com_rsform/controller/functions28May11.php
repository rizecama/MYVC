
<?php
/**
* @version 1.2.0
* @package RSform!Pro 1.2.0
* @copyright (C) 2007-2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

	function RSgetValidationRules()
	{
		$RSadapter=$GLOBALS['RSadapter'];
		
		$pattern = '#function (.*?)\(#i';
		$file = file_get_contents(_RSFORM_FRONTEND_ABS_PATH.'/controller/validation.php');
		preg_match_all($pattern,$file,$matches);
		
		$results = isset($matches[1]) ? $matches[1] : array();
		foreach ($results as $i => $result)
			$results[$i] = trim($result);
		
		return implode("\n",$results);
	}

	function RSisCode($value)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		if (preg_match('/<code>/',$value))
			return eval($value);
		else
			return $value;
	}
	
	function RSisXMLCode($value)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		if(preg_match('/{RSadapter}/',$value))
			return ($RSadapter->$value);
		else return $value;
	}

	// 1.5 ready
	function RSinitForm($formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `ComponentId`,`Order`,`ComponentTypeId`,`Published` FROM #__rsform_components WHERE `FormId`='".$formId."' ORDER BY `Order`");
		$components = $db->loadAssocList();
		
		$i = 1;
		$j = 0;
		$returnVal = '';
		
		foreach ($components as $r)
			if(array_search($r['ComponentTypeId'], $RSadapter->config['component_ids']) !== false)
			{
				$j = ($j) ? 0 : 1;
				$returnVal.='<tr class="row'.$j.'" style="height: auto">';
				$returnVal.='<td><input type="hidden" name="previewComponentId" value="'.$r['ComponentId'].'"/></td>';
				$returnVal .= '<td><input type="checkbox" name="checks[]" value="'.$r['ComponentId'].'"/></td>';
				$returnVal.=RSshowComponentName($r['ComponentId']);
				$returnVal.=RSpreviewComponent($formId,$r['ComponentId']);
				$returnVal.=RSshowEditComponentButton($r['ComponentTypeId'],$r['ComponentId']);
				$returnVal.=RSshowRemoveComponentButton($formId,$r['ComponentId']);
				$returnVal.=RSshowComponentOrdering($formId,$r['ComponentId'],$r['Order'],$i);
				$returnVal.=RSshowMoveUpComponent($formId,$r['ComponentId']);
				$returnVal.=RSshowMoveDownComponent($formId,$r['ComponentId']);
				$returnVal.=RSshowChangeStatusComponentButton($formId,$r['ComponentId'],$r['Published']);
				$returnVal.='</tr>';
				$i++;
			}
		echo $returnVal;
	}

	function RSshowComponentName($componentId)
	{
		$data = RSgetComponentProperties($componentId);
		return '<td>'.$data['NAME'].'</td>';
	}

	// 1.5 ready
	function RSgetComponentProperties($componentId)
	{
		$db = JFactory::getDBO();
		$componentId = intval($componentId);
		
		//load component properties
		$db->setQuery("SELECT `PropertyName`, `PropertyValue` FROM #__rsform_properties WHERE `ComponentId`='".$componentId."'");
		$rez = $db->loadObjectList();
		
		//set up data array with component properties
		$data=array();
		foreach($rez as $propertyObj)
			$data[$propertyObj->PropertyName]=$propertyObj->PropertyValue;
		
		$data['componentId'] = $componentId;
		return $data;
	}
	
	// 1.5 ready
	function RSpreviewComponent($formId, $componentId)
	{
		global $mainframe;
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		$componentId = intval($componentId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT #__rsform_component_types.ComponentTypeName, #__rsform_properties.PropertyName, #__rsform_properties.PropertyValue FROM #__rsform_components LEFT JOIN #__rsform_forms ON #__rsform_components.FormId = #__rsform_forms.FormId LEFT JOIN #__rsform_component_types ON #__rsform_components.ComponentTypeId = #__rsform_component_types.ComponentTypeId LEFT JOIN #__rsform_properties on #__rsform_components.ComponentId = #__rsform_components.ComponentId WHERE #__rsform_forms.FormId='".$formId."' AND #__rsform_components.ComponentId='".$componentId."'");		
		$r = $db->loadAssoc();
		
		$out='';
		
		$data = RSgetComponentProperties($componentId);
		//Trigger Event - rsfp_bk_onBeforeCreateComponentPreview
		$mainframe->triggerEvent('rsfp_bk_onBeforeCreateComponentPreview',array(array('out'=>&$out,'formId'=>$formId,'componentId'=>$componentId,'ComponentTypeName'=>$r['ComponentTypeName'],'data'=>$data)));
		switch($r['ComponentTypeName'])
		{
			case 'textBox':
			{
				$defaultValue = RSisCode($data['DEFAULTVALUE']);
				
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><input type="text" value="'.$defaultValue.'" size="'.$data['SIZE'].'"/></td>';
			}
			break;
			
			case 'textArea':
			{
				$defaultValue = RSisCode($data['DEFAULTVALUE']);	
				
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><textarea cols="'.$data['COLS'].'" rows="'.$data['ROWS'].'">'.$defaultValue.'</textarea></td>';
			}
			break;
			
			case 'selectList':
			{				
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><select '.($data['MULTIPLE']=='YES' ? 'multiple="multiple"' : '').' size="'.$data['SIZE'].'">';
				
				$aux = RSisCode($data['ITEMS']);
				
				$aux = str_replace("\r",'',$aux);
				$items = explode("\n",$aux);
				
				foreach($items as $item)
				{
					$buf=explode("|",$item);
					
					if(preg_match('/\[g\]/',$item))
					{
						$out.='<optgroup label="'.str_replace('[g]', '', $item).'">';
						continue;
					}
					if(preg_match('/\[\/g\]/',$item))
					{
						$out.='</optgroup>';
						continue;
					}
					
					if(count($buf)==1)
					{
						if(preg_match('/\[c\]/',$buf[0]))
							$out.='<option selected="selected">'.str_replace('[c]','',$buf[0]).'</option>';
						else
							$out.='<option value="'.$buf[0].'">'.$buf[0].'</option>';
					}
					if(count($buf)==2)
					{
						if(preg_match('/\[c\]/',$buf[1]))
							$out.='<option selected="selected" value="'.$buf[0].'">'.str_replace('[c]','',$buf[1]).'</option>';
						else
							$out.='<option value="'.$buf[0].'">'.$buf[1].'</option>';
					}
				}
				$out.='</select></td>';
			}
			break;
			
			case 'checkboxGroup':
			{
				$i=0;
				
				$out.='<td>'.$data['CAPTION'].'</td>';
				
				$aux = RSisCode($data['ITEMS']);
				$aux=str_replace("\r",'',$aux);
				$items=explode("\n",$aux);
				
				$out.='<td>';
				foreach($items as $item)
				{
					$buf=explode("|",$item);
					if(count($buf)==1)
					{
						if(preg_match('/\[c\]/',$buf[0]))
						{
							$v=str_replace('[c]','',$buf[0]);
							$out.='<input checked="checked" type="checkbox" value="'.$v.'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$v.'</label>';
						}
						else
							$out.='<input type="checkbox" value="'.$buf[0].'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$buf[0].'</label>';
					}
					if(count($buf)==2)
					{
						if(preg_match('/\[c\]/',$buf[1]))
						{
							$v=str_replace('[c]','',$buf[1]);
							$out.='<input checked="checked" type="checkbox" value="'.$buf[0].'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$v.'</label>';
						}
						else
							$out.='<input type="checkbox" value="'.$buf[0].'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$buf[1].'</label>';

					}
					if($data['FLOW']=='VERTICAL') $out.='<br/>';
					$i++;
				}
				$out.='</td>';

			}
			break;
			
			case 'radioGroup':
			{
				$i=0;
				
				$out.='<td>'.$data['CAPTION'].'</td>';
				
				$aux = RSisCode($data['ITEMS']);
				$aux=str_replace("\r",'',$aux);
				$items=explode("\n",$aux);
				
				$out.='<td>';
				foreach($items as $item)
				{
					$buf=explode("|",$item);
					if(count($buf)==1)
					{
						if(preg_match('/\[c\]/',$buf[0]))
						{
							$v=str_replace('[c]','',$buf[0]);
							$out.='<input checked="checked" type="radio" value="'.$v.'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$v.'</label>';
						}
						else
							$out.='<input type="radio" value="'.$buf[0].'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$buf[0].'</label>';
					}
					if(count($buf)==2)
					{
						if(preg_match('/\[c\]/',$buf[1]))
						{
							$v=str_replace('[c]','',$buf[1]);
							$out.='<input checked="checked" type="radio" value="'.$buf[0].'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$v.'</label>';
						}
						else
							$out.='<input type="radio" value="'.$buf[0].'" name="'.$data['NAME'].'" id="'.$data['NAME'].$i.'"/><label for="'.$data['NAME'].$i.'">'.$buf[1].'</label>';

					}
					if($data['FLOW']=='VERTICAL') $out.='<br/>';
					$i++;
				}
				$out.='</td>';

			}
			break;
			
			case 'calendar':
			{
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><img src="'.$RSadapter->config['live_site'].'/administrator/components/com_rsform/images/icons/calendar.gif" /> '.constant('_RSFORM_BACKEND_COMP_FVALUE_'.$data['CALENDARLAYOUT']).'</td>';
			}
			break;
			
			case 'button':
			{
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><input type="button" value="'.$data['LABEL'].'"/>';
				if ($data['RESET']=='YES')
					$out.='&nbsp;&nbsp;<input type="reset" value="'.$data['RESETLABEL'].'"/>';
				$out.='</td>';
			}
			break;
			
			case 'captcha':
			{
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td>';
				switch ($data['IMAGETYPE'])
				{
					default:
					case 'FREETYPE':
					case 'NOFREETYPE':
						$out.='<img src="'._RSFORM_FRONTEND_SCRIPT_PATH.'?option=com_rsform&amp;task=captcha&amp;componentId='.$componentId.'&amp;tmpl=component" id="captcha'.$componentId.'" alt="'.$data['CAPTION'].'"/>';
						$out.=($data['FLOW']=='HORIZONTAL') ? '':'<br/>';
						$out.='<input type="text" name="form['.$data['NAME'].']" value="" id="captchaTxt'.$componentId.'" '.$data['ADDITIONALATTRIBUTES'].' />';
						$out.=($data['SHOWREFRESH']=='YES') ? '<a href="" onclick="refreshCaptcha('.$componentId.',\''._RSFORM_FRONTEND_SCRIPT_PATH.'?option=com_rsform&amp;task=captcha&amp;componentId='.$componentId.'&amp;tmpl=component\'); return false;">'.$data['REFRESHTEXT'].'</a>':'';
					break;
					
					case 'INVISIBLE':
						$out.='{hidden captcha}';
					break;
				}
				$out.='</td>';
			}
			break;
			
			case 'fileUpload':
			{
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><input type="file" name="'.$data['NAME'].'"/></td>';
			}
			break;
			
			case 'freeText':
			{
				$out.='<td>&nbsp;</td>';
				$out.='<td>'.$data['TEXT'].'</td>';
			}
			break;
			
			case 'hidden':
			{
				$out.='<td>&nbsp;</td>';
				$out.='<td>{hidden field}</td>';
			}
			break;
			
			case 'imageButton':
			{			
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td>';
				$out.='<input type="image" src="'.$data['IMAGEBUTTON'].'"/>';
				if($data['RESET']=='YES')
					$out.='&nbsp;&nbsp;<input type="image" src="'.$data['IMAGERESET'].'"/>';
				$out.='</td>';
			}
			break;
			
			case 'submitButton':
			{				
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><input type="button" value="'.$data['LABEL'].'" />';
				if($data['RESET']=='YES')
					$out.='&nbsp;&nbsp;<input type="reset" value="'.$data['RESETLABEL'].'"/>';
				$out.='</td>';
			}
			break;
			
			case 'password':
			{				
				$out.='<td>'.$data['CAPTION'].'</td>';
				$out.='<td><input type="password" value="'.$data['DEFAULTVALUE'].'" size="'.$data['SIZE'].'"/></td>';
			}
			break;
			
			case 'ticket':
			{				
				$out.='<td>&nbsp;</td>';
				$out.='<td>'.RSgenerateString($data['LENGTH'],$data['CHARACTERS']).'</td>';
			}
			break;
			default:
				$out = '<td colspan="2" style="color:#333333"><em>'._RSFORM_BACKEND_FORMS_EDIT_COMPREVIEW_NOT_AVAILABLE.'</em></td>';
			break;
		}
		//Trigger Event - rsfp_bk_onAfterCreateComponentPreview
		$mainframe->triggerEvent('rsfp_bk_onAfterCreateComponentPreview',array(array('out'=>&$out, 'formId'=>$formId, 'componentId'=>$componentId, 'ComponentTypeName'=>$r['ComponentTypeName'],'data'=>$data)));
		
		return $out;
	}

	function RSshowEditComponentButton($formId,$componentId)
	{
		return '<td><a href="#" onclick="displayTemplate('."'".$formId."','".$componentId."'".');"><img src="components/com_rsform/images/icons/edit.png" border="0" width="16" height="16" alt="Edit Component" /></a></td>';
	}
	
	function RSshowRemoveComponentButton($formId,$componentId)
	{
		return '<td><a href="#" onclick="removeComponent('."'".$formId."','".$componentId."'".');"><img src="components/com_rsform/images/icons/remove.png" border="0" width="12" height="12" alt="Remove Component" style="padding-left:20px;" /></a></td>';
	}
	
	function RSshowChangeStatusComponentButton($formId, $componentId, $published)
	{
		return '<td><a href="#" onclick="changeStatusComponent('."'".$formId."','".$componentId."'".');"><img src="components/com_rsform/images/icons/'.($published ? 'publish':'unpublish').'.png" border="0" width="12" height="12" alt="'.($published ? 'Unpublish' : 'Publish').' Component" style="padding-left:20px;" id="currentStatus'.$componentId.'" /></a></td>';
	}
	
	function RSshowComponentOrdering($formId,$componentId,$order,$tabIndex)
	{
		return '<td><input type="text" value="'.$order.'" size="2" name="ordering['.$componentId.']" tabindex="'.$tabIndex.'"/></td>';
	}
	
	function RSshowMoveUpComponent($formId,$componentId)
	{
		return '<td><a href="#" onclick="moveComponentUp('."'".$formId."','".$componentId."'".');"><img src="components/com_rsform/images/icons/uparrow.png" border="0" width="12" height="12" alt="Move Up" /></a></td>';
	}
	
	function RSshowMoveDownComponent($formId,$componentId)
	{
		return '<td><a href="#" onclick="moveComponentDown('."'".$formId."','".$componentId."'".');"><img src="components/com_rsform/images/icons/downarrow.png" border="0" width="12" height="12" alt="Move Down" /></a></td>';
	}
	
	// 1.5 ready
	function RSgetFormLayout($formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `FormLayoutAutogenerate`,`FormLayoutName`,`FormLayout` FROM #__rsform_forms WHERE `FormId`='".$formId."'");
		$r = $db->loadAssoc();
		
		if($r['FormLayoutAutogenerate']==1)
			$layout = @include(_RSFORM_BACKEND_ABS_PATH.'/layouts/'.$r['FormLayoutName'].'.php');
		else
			$layout = $r['FormLayout'];
		
		return $layout;
	}
	
	// 1.5 ready
	function RSresolveComponentName($componentName,$formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentName = RScleanVar($componentName);
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT #__rsform_properties.ComponentId FROM #__rsform_properties LEFT JOIN #__rsform_components ON #__rsform_components.ComponentId = #__rsform_properties.ComponentId WHERE #__rsform_properties.PropertyValue='".$componentName."' AND #__rsform_properties.PropertyName='NAME' and #__rsform_components.FormId='".$formId."'");
		
		return $db->loadResult();
	}
	
	// 1.5 ready
	function RSfrontComponentCaption($componentId, $data=null)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentId = intval($componentId);
		
		if (isset($data['SHOW']) && $data['SHOW'] == 'NO') return '';
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `PropertyValue` FROM #__rsform_properties WHERE `ComponentId`='".$componentId."' AND PropertyName='CAPTION'");
		return $db->loadResult();
	}
	
	// 1.5 ready
	function RSfrontComponentDescription($componentId, $data)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentId = intval($componentId);
		
		if(isset($data['SHOW']) && $data['SHOW'] == 'NO') return '';
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `PropertyValue` FROM #__rsform_properties WHERE `ComponentId`='".$componentId."' AND PropertyName='DESCRIPTION'");
		return $db->loadResult();
	}
	
	// 1.5 ready
	function RSfrontComponentValidationMessage($componentId, $data, $value='')
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentId = intval($componentId);
		
		if(isset($data['SHOW']) && $data['SHOW'] == 'NO') return '';
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `PropertyValue` FROM #__rsform_properties WHERE ComponentId='".$componentId."' AND PropertyName='VALIDATIONMESSAGE'");
		
		$msg = $db->loadResult();
		
		if(!empty($value) && in_array($componentId,$value))
			return '<span id="component'.$componentId.'" class="formError">'.$msg.'</span>';
		else
			return '<span id="component'.$componentId.'" class="formNoError">'.$msg.'</span>';
	}
	
	// 1.5 ready
	function RSfrontLayout($formId, $formLayout)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		
		//get form title
		$db->setQuery("SELECT FormTitle FROM #__rsform_forms WHERE FormId='".$formId."'");
		$formTitle = $db->loadResult();
		
		$user = JFactory::getUser();
		
		$replace = array('{global:formtitle}', '{global:username}', '{global:userip}', '{global:userid}', '{global:useremail}', '{global:fullname}', '{global:sitename}', '{global:siteurl}');
		$with = array($formTitle, $user->get('username'), @$_SERVER['REMOTE_ADDR'], $user->get('id'), $user->get('email'), $user->get('name'), $RSadapter->config['sitename'], $RSadapter->config['live_site']);
		
		return str_replace($replace, $with, $formLayout);
	}
	
	// 1.5 ready
	function RSfrontComponentBody($formId,$componentId,$data,$value='')
	{
		global $mainframe;
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		$componentId = intval($componentId);
		
		if(is_array($value))
			foreach($value as $key=>$vl)
			{
				if(is_array($vl) && !empty($vl))
					foreach($vl as $k_vl=>$v_vl)
						$value[$key][$k_vl] = RSstripVar($value[$key][$k_vl]);
				else
					$value[$key] = RSstripVar($value[$key]);
			}
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT #__rsform_properties.PropertyName, #__rsform_properties.PropertyValue, #__rsform_components.ComponentTypeId, #__rsform_components.Order FROM #__rsform_components	LEFT JOIN #__rsform_properties on #__rsform_properties.ComponentId=#__rsform_components.ComponentId	WHERE #__rsform_components.FormId='".$formId."' AND #__rsform_components.ComponentId='".$componentId."'");
		$r = $db->loadAssoc();
		
		$out='';
		
		//Trigger Event - rsfp_bk_onBeforeCreateFrontComponentBody
		$mainframe->triggerEvent('rsfp_bk_onBeforeCreateFrontComponentBody',array(array('out'=>&$out, 'formId'=>$formId, 'componentId'=>$componentId,'data'=>$data,'value'=>$value)));
		
		switch(RSresolveComponentTypeId($r['ComponentTypeId']))
		{
			case 'textBox':
			{
				$defaultValue = RSisCode($data['DEFAULTVALUE']);
				$out .= '<input type="text" value="'.(!empty($value) ? RSshowVar($value[$data['NAME']]) : $defaultValue).'" size="'.$data['SIZE'].'" '.($data['MAXSIZE'] > 0 ? 'maxlength="'.$data['MAXSIZE'].'"' : '').' name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].'/>';
			}
			break;

			case 'textArea':
			{
				$defaultValue = RSisCode($data['DEFAULTVALUE']);
				if ($data['WYSIWYG'] == 'YES')
					$out .= $RSadapter->WYSIWYG('form['.$data['NAME'].']', (!empty($value) ? RSshowVar($value[$data['NAME']]) : $defaultValue), 'id['.$data['NAME'].']', $data['COLS']*10, $data['ROWS']*10, $data['COLS'], $data['ROWS']);
				else
					$out .= '<textarea cols="'.$data['COLS'].'" rows="'.$data['ROWS'].'" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].'>'.(!empty($value) ? RSshowVar($value[$data['NAME']]) : $defaultValue).'</textarea>';
			}
			break;

			case 'selectList':
			{
				$out .= '<select '.($data['MULTIPLE']=='YES' ? 'multiple="multiple"' : '').' name="form['.$data['NAME'].'][]" '.($data['SIZE'] > 0 ? 'size="'.$data['SIZE'].'"' : '').' id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].' >';
				$aux = RSisCode($data['ITEMS']);
				$aux = str_replace("\r","",$aux);
				$items = explode("\n",$aux);
				foreach($items as $item)
				{
					$buf = explode('|',$item);
					
					if(preg_match('/\[g\]/',$item))
					{
						$out.='<optgroup label="'.str_replace('[g]', '', $item).'">';
						continue;
					}
					if(preg_match('/\[\/g\]/',$item))
					{
						$out.='</optgroup>';
						continue;
					}
					
					$option_value = $buf[0];
					$option_value_trimmed = str_replace('[c]','',$option_value);
					$option_shown = count($buf) == 1 ? $buf[0] : $buf[1];
					$option_shown_trimmed = str_replace('[c]','',$option_shown);
					
					$option_checked = false;
					if (empty($value) && preg_match('/\[c\]/',$option_shown))
						$option_checked = true;
					if (!empty($value[$data['NAME']]) && array_search($option_value_trimmed,$value[$data['NAME']]) !== false)
						$option_checked = true;
					
					$out .= '<option '.($option_checked ? 'selected="selected"' : '').' value="'.$option_value_trimmed.'">'.$option_shown_trimmed.'</option>';
				}
				$out .= '</select>';
			}
			break;
			
			/*case 'checkboxGroup':
			{
				$i=0;
				$aux = RSisCode($data['ITEMS']);
				$aux = str_replace("\r","",$aux);
				$items = explode("\n",$aux);
				foreach($items as $item)
				{
					$buf = explode('|',$item);
					
					$option_value = $buf[0];
					$option_value_trimmed = str_replace('[c]','',$option_value);
					$option_shown = count($buf) == 1 ? $buf[0] : $buf[1];
					$option_shown_trimmed = str_replace('[c]','',$option_shown);
					
					$option_checked = false;
					if (empty($value) && preg_match('/\[c\]/',$option_shown))
						$option_checked = true;
					if (!empty($value[$data['NAME']]) && array_search($option_value_trimmed,$value[$data['NAME']]) !== false)
						$option_checked = true;
						
					$out .= '<input '.($option_checked ? 'checked="checked"' : '').' name="form['.$data['NAME'].'][]" type="checkbox" value="'.$option_value_trimmed.'" id="'.$data['NAME'].$i.'" '.$data['ADDITIONALATTRIBUTES'].' /><label for="'.$data['NAME'].$i.'">'.$option_shown_trimmed.'</label>';
					
					if($data['FLOW']=='VERTICAL') $out.='<br/>';
					$i++;
				}

			}*/
			
			case 'checkboxGroup':
			{
				$i=0;
				$aux = RSisCode($data['ITEMS']);
				$aux = str_replace("\r","",$aux);
				$items = explode("\n",$aux);
				if($data['FLOW']=='VERTICAL') $out .= "<table>";
				
				foreach($items as $item)
				{
					$buf = explode('|',$item);
					
					$option_value = $buf[0];
					$option_value_trimmed = str_replace('[c]','',$option_value);
					$option_shown = count($buf) == 1 ? $buf[0] : $buf[1];
					$option_shown_trimmed = str_replace('[c]','',$option_shown);
					
					$option_checked = false;
					if (empty($value) && preg_match('/\[c\]/',$option_shown))
						$option_checked = true;
					if (!empty($value[$data['NAME']]) && array_search($option_value_trimmed,$value[$data['NAME']]) !== false)
						$option_checked = true;
					if($data['FLOW']=='VERTICAL') $out .= '<tr><td valign="top">';	
					$out .= '<input '.($option_checked ? 'checked="checked"' : '').' name="form['.$data['NAME'].'][]" type="checkbox" value="'.$option_value_trimmed.'" id="'.$data['NAME'].$i.'" '.$data['ADDITIONALATTRIBUTES'].' />';
					if($data['FLOW']=='VERTICAL') $out .='</td><td>';
					$out .='<label for="'.$data['NAME'].$i.'">'.$option_shown_trimmed.'</label>';
					if($data['FLOW']=='VERTICAL') $out .='</td></tr>';
					
					//if($data['FLOW']=='VERTICAL') $out.='<br/>';
					$i++;
				}
				if($data['FLOW']=='VERTICAL') $out .= "</table>";
			}
			
			break;
			
			case 'radioGroup':
			{
				$i=0;
				$aux = RSisCode($data['ITEMS']);
				$aux = str_replace("\r","",$aux);
				$items = explode("\n",$aux);
				foreach($items as $item)
				{
					$buf = explode('|',$item);
					
					$option_value = $buf[0];
					$option_value_trimmed = str_replace('[c]','',$option_value);
					$option_shown = count($buf) == 1 ? $buf[0] : $buf[1];
					$option_shown_trimmed = str_replace('[c]','',$option_shown);
					
					$option_checked = false;
					if (empty($value) && preg_match('/\[c\]/',$option_shown))
						$option_checked = true;
					if (!empty($value[$data['NAME']]) && $value[$data['NAME']] == $option_value_trimmed)
						$option_checked = true;
					
					$out .= '<input '.($option_checked ? 'checked="checked"' : '').' name="form['.$data['NAME'].']" type="radio" value="'.$option_value_trimmed.'" id="'.$data['NAME'].$i.'" '.$data['ADDITIONALATTRIBUTES'].' /><label for="'.$data['NAME'].$i.'">'.$option_shown_trimmed.'</label>';
					
					if($data['FLOW']=='VERTICAL') $out.='<br/>';
					$i++;
				}

			}
			break;
			
			case 'calendar':
			{
				$calendars = RScomponentExists($formId, 6);
				$calendars = array_flip($calendars);
				$def_cal_val = (empty($value) ? '':$value[$data['NAME']]);

				switch($data['CALENDARLAYOUT'])
				{
					case 'FLAT':
						$out.='<input id="txtcal'.$calendars[$componentId].'" name="form['.$data['NAME'].']" type="text" '.($data['READONLY'] == 'YES' ? 'readonly="readonly"' : '').' class="txtCal" value="'.$def_cal_val.'" '.$data['ADDITIONALATTRIBUTES'].'/><br/>
							<div id="cal'.$calendars[$componentId].'Container" style="z-index:'.(9999-$r['Order']).'"></div>';
					break;

					case 'POPUP':
						$out .= '<input id="txtcal'.$calendars[$componentId].'" name="form['.$data['NAME'].']" type="text" '.($data['READONLY'] == 'YES' ? 'readonly="readonly"' : '').'  value="'.$def_cal_val.'" '.$data['ADDITIONALATTRIBUTES'].'/>
							<input id="btn'.$calendars[$componentId].'" type="button" value="'.$data['POPUPLABEL'].'" onclick="showHideCalendar(\'cal'.$calendars[$componentId].'Container\');" class="btnCal" '.$data['ADDITIONALATTRIBUTES'].' />
							<div id="cal'.$calendars[$componentId].'Container" style="clear:both;display:none;position:absolute;z-index:'.(9999-$r['Order']).'"></div>';
					break;
				}

			}
			break;
			
			case 'button':
			{
				$out .= '<input type="button" value="'.$data['LABEL'].'" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].' />';
				if ($data['RESET']=='YES')
					$out .= '&nbsp;&nbsp;<input type="reset" value="'.$data['RESETLABEL'].'" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].' />';
			}
			break;
			
			case 'captcha':
			{
				switch ($data['IMAGETYPE'])
				{
					default:
					case 'FREETYPE':
					case 'NOFREETYPE':
					$out .= '<img src="'._RSFORM_FRONTEND_SCRIPT_PATH.'?option=com_rsform&amp;task=captcha&amp;componentId='.$componentId.'&amp;tmpl=component" id="captcha'.$componentId.'" alt="'.$data['CAPTION'].'"/>';
					$out .= ($data['FLOW']=='HORIZONTAL') ? '':'<br/>';
					$out .= '<input type="text" name="form['.$data['NAME'].']" value="" id="captchaTxt'.$componentId.'" '.$data['ADDITIONALATTRIBUTES'].' />';
					$out .= ($data['SHOWREFRESH']=='YES') ? '<a href="javascript:void(0)" onclick="refreshCaptcha('.$componentId.',\''._RSFORM_FRONTEND_SCRIPT_PATH.'?option=com_rsform&amp;task=captcha&amp;componentId='.$componentId.'&amp;tmpl=component\'); return false;">'.$data['REFRESHTEXT'].'</a>':'';
					
					case 'INVISIBLE':
					// a list of words that spam bots might auto-complete
					$words = array('Website', 'Email', 'Name', 'Address', 'User', 'Username', 'Comment', 'Message');
					$word = $words[array_rand($words, 1)];
					
					// a list of styles so that the field is hidden
					$styles = array('display: none !important', 'position: absolute !important; left: -4000px !important; top: -4000px !important;', 'position: absolute !important; left: -4000px !important; top: -4000px !important; display: none !important', 'position: absolute !important; display: none !important', 'display: none !important; position: absolute !important; left: -4000px !important; top: -4000px !important;');
					$style = $styles[array_rand($styles, 1)];
					
					// now we're going to shuffle the properties of the html tag
					$properties = array('type="text"', 'name="'.$word.'"', 'value=""', 'style="'.$style.'"');
					shuffle($properties);
					
					$_SESSION['CAPTCHA'.$componentId] = $word;
					
					$out .= '<input '.implode(' ', $properties).' />';
					break;
				}
			}
			break;
			
			case 'fileUpload':
			{
				$out .= '<input type="hidden" name="MAX_FILE_SIZE" value="'.$data['FILESIZE'].'000" />';
				$out .= '<input type="file" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].' />';
			}
			break;
			
			case 'freeText':
			{
				$out .= $data['TEXT'];
			}
			break;
			
			case 'hidden':
			{
				$defaultValue = RSisCode($data['DEFAULTVALUE']);
				$out .= '<input type="hidden" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" value="'.$defaultValue.'" '.$data['ADDITIONALATTRIBUTES'].' />';
			}
			break;
			
			case 'imageButton':
			{
				$out .= '<input type="image" src="'.$data['IMAGEBUTTON'].'" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].' />';
				if ($data['RESET']=='YES')
					$out .= '<input type="reset" name="" id="reset_'.$data['NAME'].'" style="display: none !important" />&nbsp;&nbsp;<input onclick="document.getElementById(\'reset_'.$data['NAME'].'\').click();return false;" type="image" src="'.$data['IMAGERESET'].'" name="form['.$data['NAME'].']" '.$data['ADDITIONALATTRIBUTES'].' />';
			}
			break;
			
			case 'submitButton':
			{
				$out .= '<input type="submit" value="'.$data['LABEL'].'" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.$data['ADDITIONALATTRIBUTES'].' />';
				if ($data['RESET']=='YES')
				$out .= '&nbsp;&nbsp;<input type="reset" value="'.$data['RESETLABEL'].'" name="form['.$data['NAME'].']" '.$data['ADDITIONALATTRIBUTES'].' />';
			}
			break;
			
			case 'password':
			{
				$defaultvalue = ($data['VALIDATIONRULE'] == 'password') ? '' : $data['DEFAULTVALUE'];
				$out .= '<input type="password" value="'.$defaultvalue.'" size="'.$data['SIZE'].'" name="form['.$data['NAME'].']" id="'.$data['NAME'].'" '.($data['MAXSIZE'] > 0 ? 'maxlength="'.$data['MAXSIZE'].'"' : '').' '.$data['ADDITIONALATTRIBUTES'].' />';
			}
			break;
			
			case 'ticket':
			{
				$out .= '<input type="hidden" name="form['.$data['NAME'].']" value="'.RSgenerateString($data['LENGTH'],$data['CHARACTERS']).'" '.$data['ADDITIONALATTRIBUTES'].' />';
			}
			break;
		}
		//Trigger Event - rsfp_bk_onAfterCreateFrontComponentBody
		$mainframe->triggerEvent('rsfp_bk_onAfterCreateFrontComponentBody',array(array('out'=>&$out, 'formId'=>$formId, 'componentId'=>$componentId,'data'=>$data,'value'=>$value,'r'=>$r)));
		return $out;
	}

	// 1.5 ready
	function RSshowForm($formId,$val='',$validation='')
	{
		global $mainframe;
		$RSadapter=$GLOBALS['RSadapter'];
		
		if(!isset($GLOBALS['ismodule'])) $GLOBALS['ismodule'] = 'head';
		$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . '/controller/functions.js','js', $GLOBALS['ismodule'] );
		$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . '/front.css','css', $GLOBALS['ismodule'] );
		$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . '/assets/css/rsform.css','css', $GLOBALS['ismodule'] );
		//add the head tags for the calendar
		$calendars = RScomponentExists($formId, 6);//6 is the componentTypeId for calendar
		if(!empty($calendars))
		{
			foreach($calendars as $i=>$calendarComponentId)
			{
				$data = RSgetComponentProperties($calendarComponentId);
				$calendars['CALENDARLAYOUT'][$i] = $data['CALENDARLAYOUT'];
				$calendars['DATEFORMAT'][$i] = $data['DATEFORMAT'];
				if(!empty($_POST))
				{
					if ($_POST['form'][$data['NAME']]!='')
						$calendars['VALUES'][$i] = $_POST['form'][$data['NAME']];// date('m/d/Y',strtotime($_POST['form'][$data['NAME']]));
					else
						$calendars['VALUES'][$i] = '';
				}else
					$calendars['VALUES'][$i] = '';
			}
			$calendarsLayout = "'".implode("','", $calendars['CALENDARLAYOUT'])."'";
			$calendarsFormat = "'".implode("','", $calendars['DATEFORMAT'])."'";
			$calendarsValues = "'".implode("','", $calendars['VALUES'])."'";
			//check if it's a module
			//$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . '/calendar/cal.js','js',$GLOBALS['ismodule'] );
			$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . "/calendar/calendar.css",'css',$GLOBALS['ismodule'] );
			//$RSadapter->addHeadTag( _RSFORM_FRONTEND_SCRIPT_PATH.'?option=com_rsform&amp;task=showJs','js', $GLOBALS['ismodule'] );
			$calSetup = '';
		}
		
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `FormId`, `FormLayout`, `ScriptDisplay`, `ErrorMessage` FROM #__rsform_forms WHERE FormId='".$formId."' AND `Published`='1'");
		$r = $db->loadAssoc();
		
		if (empty($r['FormId'])) return JText::_('_NOT_EXIST');
		
		$scriptDisplay = $r['ScriptDisplay'];
		$formLayout = $r['FormLayout'];
		$errorMessage = $r['ErrorMessage'];
		
		$find=array();
		$replace=array();
		
		$db->setQuery("SELECT #__rsform_properties.PropertyValue, #__rsform_components.ComponentId, #__rsform_components.ComponentTypeId FROM #__rsform_properties LEFT JOIN #__rsform_components ON #__rsform_components.ComponentId=#__rsform_properties.ComponentId WHERE #__rsform_components.FormId='".$formId."' AND #__rsform_properties.PropertyName='NAME' AND #__rsform_components.Published='1'");
		$rez = $db->loadAssocList();
		
		foreach ($rez as $r)
		{
			$data = RSgetComponentProperties($r['ComponentId']);
			//Caption
			$find[] = '{'.$r['PropertyValue'].':caption}';
			$replace[] = RSfrontComponentCaption($r['ComponentId'],$data);
			
			//Body	
			$find[] = '{'.$r['PropertyValue'].':body}';
			$replace[] = RSfrontComponentBody($formId,$r['ComponentId'],$data,$val);
			
			//Description
			$find[] = '{'.$r['PropertyValue'].':description}';
			$replace[] = RSfrontComponentDescription($r['ComponentId'],$data);
			
			//Validation rules hidden
			$find[] = '{'.$r['PropertyValue'].':validation}';
			$replace[] = RSfrontComponentValidationMessage($r['ComponentId'],$data,$validation);
		}
		
		// IIS hack
		if ($RSadapter->config['global.iis'] && !empty($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'IIS') !== false && !empty($_SERVER['QUERY_STRING']))
		{
			$u = JRoute::_('index.php?'.$_SERVER['QUERY_STRING']);
		}
		else
		{
			$u = JFactory::getURI();
			$u = $u->toString();
		}
		
		//Trigger Event - onInitFormDisplay
		$mainframe->triggerEvent('rsfp_f_onInitFormDisplay',array(array('find'=>&$find,'replace'=>&$replace,'formLayout'=>&$formLayout)));
		
		$formLayout = str_replace($find,$replace,$formLayout);
		$formLayout = RSfrontLayout($formId, $formLayout);
		
		if (strpos($formLayout, 'class="formError"') !== false)
			$formLayout = str_replace('{error}', $errorMessage, $formLayout);
		else
			$formLayout = str_replace('{error}', '', $formLayout);
		
		$formLayout.= '<input type="hidden" name="form[formId]" value="'.$formId.'"/>';
		$formLayout = '<form method="post" id="userForm" enctype="multipart/form-data" action="'.$u.'">'.$formLayout.'</form>';
		if(!empty($calendars))
		{
			$formLayout .= '
			<script type="text/javascript" src="'._RSFORM_FRONTEND_REL_PATH.'/calendar/cal.js"></script>
			<script type="text/javascript">'._RSFORM_FRONTEND_CALENDARJS.'</script>
			<script type="text/javascript" defer="defer">rsf_CALENDAR.util.Event.addListener(window, "load", init(Array('.$calendarsLayout.'),Array('.$calendarsFormat.'),Array('.$calendarsValues.')));</script>' ;
		}
		
		eval($scriptDisplay);
		
		//Trigger Event - onBeforeFormDisplay
		$mainframe->triggerEvent('rsfp_f_onBeforeFormDisplay', array(array('formLayout'=>&$formLayout,'formId'=>$formId)));
		return $formLayout;
	}

	// 1.5 ready
	function RSshowThankyouMessage($formId)
	{
		global $mainframe;
		$RSadapter=$GLOBALS['RSadapter'];
		$output = '';

		//check return url
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `ReturnUrl` FROM #__rsform_forms WHERE `formId` = '".$formId."'");
		
		$returnUrl = $db->loadResult();
	
		if (!isset($_SESSION['form'][$formId]['submissionId']))
			$_SESSION['form'][$formId]['submissionId'] = '';
			
		$returnUrl = RSprocessField($returnUrl,$_SESSION['form'][$formId]['submissionId']);

$db->setQuery("Select * from #__rsform_submission_values where SubmissionId='".$_SESSION[rfp][industry]."'");
$industrys = $db->loadobjectlist();
$os = array("Submit", "formId");
foreach($industrys as $industry){
if (!in_array($industry->FieldName, $os)) {
$linetask.=$industry->FieldName.':'.$industry->FieldValue.' , ';
}




}
$linetask1=RScleanVar($linetask);

	/*$db->setQuery("SELECT `FormName` FROM #__rsform_forms WHERE `formId` = '".$formId."'");
	$FormName = $db->loadResult();*/
		?>

	<script type="text/javascript">	
	/*window.parent.document.getElementById("title_task1").value ='<?php //echo $FormName; ?>';*/
window.parent.document.getElementById("line_taskdesc").value ='<?php echo nl2br($linetask1); ?>';
window.parent.document.getElementById( 'sbox-window' ).close(); 
		</script>
		
<?

		if (!empty($returnUrl))
			$goto = "document.location='".$returnUrl."';";
		else
			$goto = 'document.location.reload();';

		$output .= base64_decode($_SESSION['form'][$formId]['thankYouMessage']).sprintf(_RSFORM_FRONTEND_THANKYOU_BUTTON,$goto);
		unset($_SESSION['form'][$formId]['thankYouMessage']);

		//Trigger Event - onAfterShowThankyouMessage
		$mainframe->triggerEvent('rsfp_f_onAfterShowThankyouMessage', array(array('output'=>&$output,'formId'=>&$formId)));
		
		return $output;
	}

///show cam form 



function camassitantform($formId,$val='',$validation='')
	{
		global $mainframe;
		$RSadapter=$GLOBALS['RSadapter'];
		
		if(!isset($GLOBALS['ismodule'])) $GLOBALS['ismodule'] = 'head';
		$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . '/controller/functions.js','js', $GLOBALS['ismodule'] );
		$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . '/front.css','css', $GLOBALS['ismodule'] );
		//add the head tags for the calendar
		$calendars = RScomponentExists($formId, 6);//6 is the componentTypeId for calendar
		if(!empty($calendars))
		{
			foreach($calendars as $i=>$calendarComponentId)
			{
				$data = RSgetComponentProperties($calendarComponentId);
				$calendars['CALENDARLAYOUT'][$i] = $data['CALENDARLAYOUT'];
				$calendars['DATEFORMAT'][$i] = $data['DATEFORMAT'];
				if(!empty($_POST))
				{
					if ($_POST['form'][$data['NAME']]!='')
						$calendars['VALUES'][$i] = $_POST['form'][$data['NAME']];// date('m/d/Y',strtotime($_POST['form'][$data['NAME']]));
					else
						$calendars['VALUES'][$i] = '';
				}else
					$calendars['VALUES'][$i] = '';
			}
			$calendarsLayout = "'".implode("','", $calendars['CALENDARLAYOUT'])."'";
			$calendarsFormat = "'".implode("','", $calendars['DATEFORMAT'])."'";
			$calendarsValues = "'".implode("','", $calendars['VALUES'])."'";
			//check if it's a module
			//$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . '/calendar/cal.js','js',$GLOBALS['ismodule'] );
			$RSadapter->addHeadTag( _RSFORM_FRONTEND_REL_PATH . "/calendar/calendar.css",'css',$GLOBALS['ismodule'] );
			//$RSadapter->addHeadTag( _RSFORM_FRONTEND_SCRIPT_PATH.'?option=com_rsform&amp;task=showJs','js', $GLOBALS['ismodule'] );
			$calSetup = '';
		}
		
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `FormId`, `FormLayout`, `ScriptDisplay`, `ErrorMessage` FROM #__rsform_forms WHERE FormId='".$formId."' AND `Published`='1'");
		$r = $db->loadAssoc();
		
		if (empty($r['FormId'])) return JText::_('_NOT_EXIST');
		
		$scriptDisplay = $r['ScriptDisplay'];
		$formLayout = $r['FormLayout'];
		$errorMessage = $r['ErrorMessage'];
		
		$find=array();
		$replace=array();
		
		$db->setQuery("SELECT #__rsform_properties.PropertyValue, #__rsform_components.ComponentId, #__rsform_components.ComponentTypeId FROM #__rsform_properties LEFT JOIN #__rsform_components ON #__rsform_components.ComponentId=#__rsform_properties.ComponentId WHERE #__rsform_components.FormId='".$formId."' AND #__rsform_properties.PropertyName='NAME' AND #__rsform_components.Published='1'");
		$rez = $db->loadAssocList();
		
		foreach ($rez as $r)
		{
			$data = RSgetComponentProperties($r['ComponentId']);
			//Caption
			$find[] = '{'.$r['PropertyValue'].':caption}';
			$replace[] = RSfrontComponentCaption($r['ComponentId'],$data);
			
			//Body	
			$find[] = '{'.$r['PropertyValue'].':body}';
			$replace[] = RSfrontComponentBody($formId,$r['ComponentId'],$data,$val);
			
			//Description
			$find[] = '{'.$r['PropertyValue'].':description}';
			$replace[] = RSfrontComponentDescription($r['ComponentId'],$data);
			
			//Validation rules hidden
			$find[] = '{'.$r['PropertyValue'].':validation}';
			$replace[] = RSfrontComponentValidationMessage($r['ComponentId'],$data,$validation);
		}
		

		//Trigger Event - onInitFormDisplay
		$mainframe->triggerEvent('rsfp_f_onInitFormDisplay',array(array('find'=>&$find,'replace'=>&$replace,'formLayout'=>&$formLayout)));
		
		$formLayout = str_replace($find,$replace,$formLayout);
		$formLayout = RSfrontLayout($formId, $formLayout);
		
		if (strpos($formLayout, 'class="formError"') !== false)
			$formLayout = str_replace('{error}', $errorMessage, $formLayout);
		else
			$formLayout = str_replace('{error}', '', $formLayout);
		
		$formLayout.= '<input type="hidden" name="form[formId]" value="'.$formId.'"/>';
		if(!empty($calendars))
		{
			$formLayout .= '
			<script type="text/javascript" src="'._RSFORM_FRONTEND_REL_PATH.'/calendar/cal.js"></script>
			<script type="text/javascript">'._RSFORM_FRONTEND_CALENDARJS.'</script>
			<script type="text/javascript" defer="defer">rsf_CALENDAR.util.Event.addListener(window, "load", init(Array('.$calendarsLayout.'),Array('.$calendarsFormat.'),Array('.$calendarsValues.')));</script>' ;
		}
		
		eval($scriptDisplay);
		
		//Trigger Event - onBeforeFormDisplay
		$mainframe->triggerEvent('rsfp_f_onBeforeFormDisplay', array(array('formLayout'=>&$formLayout,'formId'=>$formId)));
		return $formLayout;
	}





///end show cam form 










	// 1.5 ready
	function RSprocessForm($formId)
	{
		global $mainframe;
		$RSadapter=$GLOBALS['RSadapter'];
		//$user = $RSadapter->user();
		$user = JFactory::getUser();
		
		// todo - keep just one parameter, either $_POST or formId
		$formId = intval($formId);
		$_POST['form']['formId'] = intval($_POST['form']['formId']);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `ScriptProcess`, `ScriptProcess2` FROM #__rsform_forms WHERE `FormId`='".$_POST['form']['formId']."'");
		$r = $db->loadAssoc();
		
		$ScriptProcess = $r['ScriptProcess'];
		$ScriptProcess2 = $r['ScriptProcess2'];
		
		$invalid=array();
		$invalid=RSvalidateForm($_POST['form']['formId']);
		
		//Trigger Event - onBeforeFormValidation
		$mainframe->triggerEvent('rsfp_f_onBeforeFormValidation', array(array('invalid'=>&$invalid)));
		
		if(!empty($invalid)) return $invalid;//showForm($formId,$_POST['form'],$invalid);
		
		$userEmail=array(
			'to'=>'',
			'cc'=>'',
			'bcc'=>'',
			'from'=>'',
			'replyto'=>'',
			'fromName'=>'',
			'text'=>'',
			'subject'=>'',
			'files' =>array()
			);
		$adminEmail=array(
			'to'=>'',
			'cc'=>'',
			'bcc'=>'',
			'from'=>'',
			'replyto'=>'',
			'fromName'=>'',
			'text'=>'',
			'subject'=>'',
			'files' =>array()
			);
			
		eval($ScriptProcess);
		//Trigger Event - onBeforeFormProcess
		$mainframe->triggerEvent('rsfp_f_onBeforeFormProcess');
		
		if(empty($invalid))
		{
			$file='';
			$dest=array();
			$tmp_name=array();
			$name=array();
			$fieldName=array();
			$user->username = RScleanVar($user->username);
			$user->id = intval($user->id);
			
			$db->setQuery("INSERT INTO #__rsform_submissions SET `FormId`='".$_POST['form']['formId']."', `DateSubmitted`=NOW(), `UserIp`='".$_SERVER['REMOTE_ADDR']."', `Username`='".$user->username."', `UserId`='".$user->id."'");
			$db->query();
			
		$SubmissionId = $db->insertid();
		$_SESSION[rfp][industry]=$SubmissionId;
		
			
			$files = JRequest::get('files');
			if(isset($files['form']['tmp_name']) && is_array($files['form']['tmp_name']))
			{
				foreach($files['form']['name'] as $key=>$val)
					if(!empty($files['form']['name'][$key]))
					{
						$dest[] = RSgetFileDestination($key,$_POST['form']['formId']);
						$val = str_replace("'", '', $val);
						$val = get_magic_quotes_gpc() ? stripslashes($val) : $val;
						$name[] = $val;
						$fieldName[] = $key;
					}

				foreach($files['form']['tmp_name'] as $key=>$val)
					if(!empty($files['form']['name'][$key]))
						$tmp_name[] = $val;

				
				for($i=0;$i<count($dest);$i++)
					if(isset($tmp_name[$i]))
					{
						$fieldName[$i] = RScleanVar($fieldName[$i]);
						
						$prop = RSgetComponentProperties(RSresolveComponentName($fieldName[$i],$formId));
						
						// todo - customize prefix
						$timestamp = uniqid('');
						// todo - handle files through joomla
						move_uploaded_file($tmp_name[$i],$dest[$i].$timestamp.'-'.$name[$i]);
						@chmod($dest[$i].$timestamp.'-'.$name[$i],0644);
						$file = $dest[$i].$timestamp.'-'.$name[$i];
						//$db = RScleanVar($db);
						$file = $db->getEscaped($file);
						if ($prop['ATTACHUSEREMAIL']=='YES')
							$userEmail['files'][] = $file;
						if ($prop['ATTACHADMINEMAIL']=='YES')
							$adminEmail['files'][] = $file;

						$db->setQuery("INSERT INTO #__rsform_submission_values SET `SubmissionId`='".$SubmissionId."', `FormId`='".$_POST['form']['formId']."', `FieldName`='".$fieldName[$i]."', `FieldValue`='".$file."'");
						$db->query();
					}
			}

			//Trigger Event - onBeforeStoreSubmissions
			$mainframe->triggerEvent('rsfp_f_onBeforeStoreSubmissions', array(array('formId'=>$formId,'post'=>&$_POST['form'])));
			
			foreach ($_POST['form'] as $key => $val)
			{
				$val = (is_array($val) ? implode("\n",$val) : $val);
				$key = RScleanVar($key);
				$val = RScleanVar(RSstripjavaVar($val));
				
				$db->setQuery("INSERT INTO #__rsform_submission_values SET `SubmissionId`='".$SubmissionId."', `FormId`='".$_POST['form']['formId']."', `FieldName`='".$key."', `FieldValue`='".$val."'");
				$db->query();
			}
			//Trigger Event - onAfterStoreSubmissions
			$mainframe->triggerEvent('rsfp_f_onAfterStoreSubmissions', array(array('SubmissionId'=>$SubmissionId,'formId'=>$formId)));
			//if(defined('_RSFORM_PLUGIN_MAPPINGS')) RSmappingsWriteSubmissions($formId, $SubmissionId);
			//die();				
			
			$db->setQuery("SELECT * FROM #__rsform_forms WHERE FormId='".$_POST['form']['formId']."'");
			$r = $db->loadAssoc();
			
			$userEmail['to']=RSprocessField($r['UserEmailTo'],$SubmissionId);
			$userEmail['cc']=RSprocessField($r['UserEmailCC'],$SubmissionId);
			$userEmail['bcc']=RSprocessField($r['UserEmailBCC'],$SubmissionId);
			$userEmail['subject']=RSprocessField($r['UserEmailSubject'],$SubmissionId);
			$userEmail['from']=RSprocessField($r['UserEmailFrom'],$SubmissionId);
			$userEmail['replyto']=RSprocessField($r['UserEmailReplyTo'],$SubmissionId);
			$userEmail['fromName']=RSprocessField($r['UserEmailFromName'],$SubmissionId);
			$userEmail['text']=RSprocessField($r['UserEmailText'],$SubmissionId);
			$userEmail['mode']=$r['UserEmailMode'];

			
			$adminEmail['to']=RSprocessField($r['AdminEmailTo'],$SubmissionId);
			$adminEmail['cc']=RSprocessField($r['AdminEmailCC'],$SubmissionId);
			$adminEmail['bcc']=RSprocessField($r['AdminEmailBCC'],$SubmissionId);
			$adminEmail['subject']=RSprocessField($r['AdminEmailSubject'],$SubmissionId);
			$adminEmail['from']=RSprocessField($r['AdminEmailFrom'],$SubmissionId);
			$adminEmail['replyto']=RSprocessField($r['AdminEmailReplyTo'],$SubmissionId);
			$adminEmail['fromName']=RSprocessField($r['AdminEmailFromName'],$SubmissionId);
			$adminEmail['text']=RSprocessField($r['AdminEmailText'],$SubmissionId);
			$adminEmail['mode']=$r['AdminEmailMode'];

			// todo - change rsadapter->mail to jutility::sendmail
			//mail users
			$recipients = explode(',',$userEmail['to']);
			// cc
			if (strpos($userEmail['cc'], ',') !== false)
				$userEmail['cc'] = explode(',', $userEmail['cc']);
			// bcc
			if (strpos($userEmail['bcc'], ',') !== false)
				$userEmail['bcc'] = explode(',', $userEmail['bcc']);
			
			if ($r['UserEmailAttach'] && file_exists(RSprocessField($r['UserEmailAttachFile'],$SubmissionId)))
				$userEmail['files'][] = RSprocessField($r['UserEmailAttachFile'],$SubmissionId);
			
			
			if(!empty($recipients))
				foreach($recipients as $recipient)
					if(!empty($recipient))
						$RSadapter->mail($userEmail['from'], $userEmail['fromName'], $recipient, $userEmail['subject'], $userEmail['text'], $userEmail['mode'], !empty($userEmail['cc']) ? $userEmail['cc'] : null, !empty($userEmail['bcc']) ? $userEmail['bcc'] : null, $userEmail['files'], !empty($userEmail['replyto']) ? $userEmail['replyto'] : '');
						
			//mail admins
			$recipients = explode(',',$adminEmail['to']);
			// cc
			if (strpos($adminEmail['cc'], ',') !== false)
				$adminEmail['cc'] = explode(',', $adminEmail['cc']);
			// bcc
			if (strpos($adminEmail['bcc'], ',') !== false)
				$adminEmail['bcc'] = explode(',', $adminEmail['bcc']);
			if(!empty($recipients))
				foreach($recipients as $recipient)
					if(!empty($recipient))
						$RSadapter->mail($adminEmail['from'], $adminEmail['fromName'], $recipient, $adminEmail['subject'], $adminEmail['text'], $adminEmail['mode'], !empty($adminEmail['cc']) ? $adminEmail['cc'] : null, !empty($adminEmail['bcc']) ? $adminEmail['bcc'] : null, $adminEmail['files'], !empty($adminEmail['replyto']) ? $adminEmail['replyto'] : '');
			
			$thankYouMessage = RSprocessField($r['Thankyou'],$SubmissionId);
			
			eval($ScriptProcess2);
			//Trigger - After form process
			$mainframe->triggerEvent('rsfp_f_onAfterFormProcess', array(array('SubmissionId'=>$SubmissionId,'formId'=>$formId)));
			
			// SESSION quick hack - we base64 encode it here and decode it when we show it
			$_SESSION['form'][$formId]['thankYouMessage'] = base64_encode($thankYouMessage);
			$_SESSION['form'][$formId]['submissionId'] = $SubmissionId;
			
			// IIS hack
			if ($RSadapter->config['global.iis'] && !empty($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'IIS') !== false && !empty($_SERVER['QUERY_STRING']))
			{
				$u = JRoute::_('index.php?'.$_SERVER['QUERY_STRING'],false);
			}
			else
			{
				$u = JFactory::getURI();
				$u = $u->toString();
			}
			$RSadapter->redirect($u);
		}

		return false;
	}

	// 1.5 ready
	function RSgetSubmissionValue($SubmissionId, $ComponentId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$data = RSgetComponentProperties($ComponentId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `FieldValue` FROM #__rsform_submission_values WHERE FieldName = '".$data['NAME']."' AND SubmissionId = '".$SubmissionId."'");
		$FieldValue = $db->loadResult();
		
		return $FieldValue;
	}
	
	// todo - use Joomla! string functions
	function RScleanVar($string,$html=false)
	{
		$db = JFactory::getDBO();
		$string = $html ? htmlentities($string,ENT_COMPAT,'UTF-8') : $string;
		$string = get_magic_quotes_gpc() ? $db->getEscaped(stripslashes($string)) : $db->getEscaped($string);
		return $string;
	}
	
	// todo - use Joomla! string functions
	function RSshowVar($string)
	{
		return htmlspecialchars($string);
	}
	
	// todo - use Joomla! string functions
	function RSstripVar($string)
	{
		$string = get_magic_quotes_gpc() ? stripslashes($string) : $string;
		return $string;
	}
	
	// todo - use Joomla! string functions
	// optimize to ignore false alerts
	function RSstripjavaVar($val)
	{
	   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	   // this prevents some character re-spacing such as <java\0script>
	   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	   $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

	   // straight replacements, the user should never need these since they're normal characters
	   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
	   $search = 'abcdefghijklmnopqrstuvwxyz';
	   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   $search .= '1234567890!@#$%^&*()';
	   $search .= '~`";:?+/={}[]-_|\'\\';
	   for ($i = 0; $i < strlen($search); $i++) {
	      // ;? matches the ;, which is optional
	      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

	      // &#x0040 @ search for the hex values
	      $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
	      // &#00064 @ 0{0,7} matches '0' zero to seven times
	      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
	   }

	   // now the only remaining whitespace attacks are \t, \n, and \r
	   // ([ \t\r\n]+)?
	   $ra1 = Array('\/([ \t\r\n]+)?javascript', '\/([ \t\r\n]+)?vbscript', ':([ \t\r\n]+)?expression', '<([ \t\r\n]+)?applet', '<([ \t\r\n]+)?meta', '<([ \t\r\n]+)?xml', '<([ \t\r\n]+)?blink', '<([ \t\r\n]+)?link', '<([ \t\r\n]+)?style', '<([ \t\r\n]+)?script', '<([ \t\r\n]+)?embed', '<([ \t\r\n]+)?object', '<([ \t\r\n]+)?iframe', '<([ \t\r\n]+)?frame', '<([ \t\r\n]+)?frameset', '<([ \t\r\n]+)?ilayer', '<([ \t\r\n]+)?layer', '<([ \t\r\n]+)?bgsound', '<([ \t\r\n]+)?title', '<([ \t\r\n]+)?base');
	   $ra2 = Array('onabort([ \t\r\n]+)?=', 'onactivate([ \t\r\n]+)?=', 'onafterprint([ \t\r\n]+)?=', 'onafterupdate([ \t\r\n]+)?=', 'onbeforeactivate([ \t\r\n]+)?=', 'onbeforecopy([ \t\r\n]+)?=', 'onbeforecut([ \t\r\n]+)?=', 'onbeforedeactivate([ \t\r\n]+)?=', 'onbeforeeditfocus([ \t\r\n]+)?=', 'onbeforepaste([ \t\r\n]+)?=', 'onbeforeprint([ \t\r\n]+)?=', 'onbeforeunload([ \t\r\n]+)?=', 'onbeforeupdate([ \t\r\n]+)?=', 'onblur([ \t\r\n]+)?=', 'onbounce([ \t\r\n]+)?=', 'oncellchange([ \t\r\n]+)?=', 'onchange([ \t\r\n]+)?=', 'onclick([ \t\r\n]+)?=', 'oncontextmenu([ \t\r\n]+)?=', 'oncontrolselect([ \t\r\n]+)?=', 'oncopy([ \t\r\n]+)?=', 'oncut([ \t\r\n]+)?=', 'ondataavailable([ \t\r\n]+)?=', 'ondatasetchanged([ \t\r\n]+)?=', 'ondatasetcomplete([ \t\r\n]+)?=', 'ondblclick([ \t\r\n]+)?=', 'ondeactivate([ \t\r\n]+)?=', 'ondrag([ \t\r\n]+)?=', 'ondragend([ \t\r\n]+)?=', 'ondragenter([ \t\r\n]+)?=', 'ondragleave([ \t\r\n]+)?=', 'ondragover([ \t\r\n]+)?=', 'ondragstart([ \t\r\n]+)?=', 'ondrop([ \t\r\n]+)?=', 'onerror([ \t\r\n]+)?=', 'onerrorupdate([ \t\r\n]+)?=', 'onfilterchange([ \t\r\n]+)?=', 'onfinish([ \t\r\n]+)?=', 'onfocus([ \t\r\n]+)?=', 'onfocusin([ \t\r\n]+)?=', 'onfocusout([ \t\r\n]+)?=', 'onhelp([ \t\r\n]+)?=', 'onkeydown([ \t\r\n]+)?=', 'onkeypress([ \t\r\n]+)?=', 'onkeyup([ \t\r\n]+)?=', 'onlayoutcomplete([ \t\r\n]+)?=', 'onload([ \t\r\n]+)?=', 'onlosecapture([ \t\r\n]+)?=', 'onmousedown([ \t\r\n]+)?=', 'onmouseenter([ \t\r\n]+)?=', 'onmouseleave([ \t\r\n]+)?=', 'onmousemove([ \t\r\n]+)?=', 'onmouseout([ \t\r\n]+)?=', 'onmouseover([ \t\r\n]+)?=', 'onmouseup([ \t\r\n]+)?=', 'onmousewheel([ \t\r\n]+)?=', 'onmove([ \t\r\n]+)?=', 'onmoveend([ \t\r\n]+)?=', 'onmovestart([ \t\r\n]+)?=', 'onpaste([ \t\r\n]+)?=', 'onpropertychange([ \t\r\n]+)?=', 'onreadystatechange([ \t\r\n]+)?=', 'onreset([ \t\r\n]+)?=', 'onresize([ \t\r\n]+)?=', 'onresizeend([ \t\r\n]+)?=', 'onresizestart([ \t\r\n]+)?=', 'onrowenter([ \t\r\n]+)?=', 'onrowexit([ \t\r\n]+)?=', 'onrowsdelete([ \t\r\n]+)?=', 'onrowsinserted([ \t\r\n]+)?=', 'onscroll([ \t\r\n]+)?=', 'onselect([ \t\r\n]+)?=', 'onselectionchange([ \t\r\n]+)?=', 'onselectstart([ \t\r\n]+)?=', 'onstart([ \t\r\n]+)?=', 'onstop([ \t\r\n]+)?=', 'onsubmit([ \t\r\n]+)?=', 'onunload([ \t\r\n]+)?=');
	   $ra = array_merge($ra1, $ra2);

	   /*
	   $found = true; // keep replacing as long as the previous round replaced something
	   while ($found == true) {
	      $val_before = $val;
	      for ($i = 0; $i < sizeof($ra); $i++) {
	         $pattern = '/';
	         for ($j = 0; $j < strlen($ra[$i]); $j++) {
	            if ($j > 0) {
	               $pattern .= '(';
	               $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
	               $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
	               $pattern .= ')?';
	            }
	            $pattern .= $ra[$i][$j];
	         }
	         $pattern .= '/i';
	         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
			 echo $pattern;
			 die();
	         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
	         if ($val_before == $val) {
	            // no replacements were made, so exit the loop
	            $found = false;
	         }
	      }
	   }
	   */
	   
		foreach ($ra as $tag)
		{
			$pattern = '#'.$tag.'#i';
			preg_match_all($pattern, $val, $matches);
			
			foreach ($matches[0] as $match)
				$val = str_replace($match, substr($match, 0, 2).'<x>'.substr($match, 2), $val);
		}
	   
	   return $val;
	}
	
	// 1.5 ready
	function RSgetValidationRule($componentId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentId = intval($componentId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT PropertyValue FROM #__rsform_properties WHERE PropertyName='VALIDATIONRULE' and ComponentId='".$componentId."'");
		return $db->loadResult();
	}

	// 1.5 ready
	function RSgetRequired($value,$formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];

		$formId = intval($formId);
		$componentId=RSresolveComponentName($value,$formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT PropertyValue FROM #__rsform_properties WHERE PropertyName='REQUIRED' AND ComponentId='".$componentId."'");
		
		return $db->loadResult();
	}
	
	// 1.5 ready
	// todo - optimize validations
	function RSvalidateForm($formId)
	{
		global $mainframe;
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		
		$invalid=array();
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT ComponentId FROM #__rsform_components WHERE FormId='".$formId."' AND Published=1");
		$components = $db->loadAssocList();
		
		foreach ($components as $r)
		{
			$data = RSgetComponentProperties($r['ComponentId']);
			$required = RSgetRequired($data['NAME'],$formId);
			$validationRule = RSgetValidationRule($r['ComponentId']);

			$typeId = RSgetComponentTypeId($r['ComponentId']);
			
			if ($typeId == 8)
			{
				if ($data['IMAGETYPE'] == 'INVISIBLE')
				{
					if (!empty($_POST[$_SESSION['CAPTCHA'.$r['ComponentId']]]))
						$invalid[] = $data['componentId'];
				}
				else
				{
					if (empty($_POST['form'][$data['NAME']]) || empty($_SESSION['CAPTCHA'.$r['ComponentId']]) || $_POST['form'][$data['NAME']]!=$_SESSION['CAPTCHA'.$r['ComponentId']])
						$invalid[] = $data['componentId'];
				}
			}
			
			if($typeId == 14)
			{
				if ($data['VALIDATIONRULE'] == 'password')
				{
					if ($_POST['form'][$data['NAME']] != $data['DEFAULTVALUE'])
						$invalid[] = $data['componentId'];
				}
			}
			
			//Trigger Event - rsfp_bk_validate_onSubmitValidateRecaptcha
			if($typeId == 24)
				$mainframe->triggerEvent('rsfp_bk_validate_onSubmitValidateRecaptcha',array(array('data'=> &$data,'invalid'=> &$invalid)));
			
			if($typeId == 9)
			{
				// File has been *sent* to the server
				if (isset($_FILES['form']['tmp_name'][$data['NAME']]) && $_FILES['form']['error'][$data['NAME']] != 4)
				{
					// File has been uploaded correctly to the server
					if($_FILES['form']['error'][$data['NAME']] == 0)
					{
						// Let's check if the extension is allowed
						$buf = explode('.',$_FILES['form']['name'][$data['NAME']]);
						$m = '#'.$buf[count($buf)-1].'#';
						if (!empty($data['ACCEPTEDFILES']) && !preg_match(strtolower($m),strtolower($data['ACCEPTEDFILES'])))
							$invalid[] = $data['componentId'];
						// Let's check if it's the correct size
						if ($_FILES['form']['size'][$data['NAME']] > 0 && $data['FILESIZE'] > 0 && $_FILES['form']['size'][$data['NAME']] > $data['FILESIZE']*1024)
							$invalid[] = $data['componentId'];
					}
					// File has not been uploaded correctly - next version we'll trigger some messages based on the error code
					else
						$invalid[] = $data['componentId'];
				}
				// File has not been sent but it's required
				elseif($data['REQUIRED']=='YES')
					$invalid[] = $data['componentId'];
				
				continue;
			}
			
			if ($required == 'YES')
			{
				if(!isset($_POST['form'][$data['NAME']]))
				{
					$invalid[] = $data['componentId'];
					continue;
				}
				if (!is_array($_POST['form'][$data['NAME']]) && strlen(trim($_POST['form'][$data['NAME']])) == 0)
				{
					$invalid[] = $data['componentId'];
					continue;
				}
				if (!is_array($_POST['form'][$data['NAME']]) && strlen(trim($_POST['form'][$data['NAME']])) > 0 && is_callable($validationRule) && call_user_func($validationRule,$_POST['form'][$data['NAME']],isset($data['VALIDATIONEXTRA']) ? $data['VALIDATIONEXTRA'] : '') == false)
				{
					$invalid[] = $data['componentId'];
					continue;
				}
				if (is_array($_POST['form'][$data['NAME']]))
				{
					$valid=implode('',$_POST['form'][$data['NAME']]);
					if(empty($valid))
					{
						$invalid[] = $data['componentId'];
						continue;
					}
				}
			}
			else
			{
				if (isset($_POST['form'][$data['NAME']]) && !is_array($_POST['form'][$data['NAME']]) && strlen(trim($_POST['form'][$data['NAME']])) > 0 && is_callable($validationRule) && call_user_func($validationRule,$_POST['form'][$data['NAME']],isset($data['VALIDATIONEXTRA']) ? $data['VALIDATIONEXTRA'] : '' ) == false)
				{
					$invalid[] = $data['componentId'];
					continue;
				}
			}
		}
		return $invalid;
	}

	// 1.5 ready
	function RSgetComponentTypeId($componentId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentId = intval($componentId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT ComponentTypeId FROM #__rsform_components WHERE ComponentId='".$componentId."'");
		
		return $db->loadResult();
	}
	
	// 1.5 ready
	function RSresolveComponentTypeId($componentTypeId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentTypeId = intval($componentTypeId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT ComponentTypeName FROM #__rsform_component_types WHERE ComponentTypeId='".$componentTypeId."'");
		
		return $db->loadResult();
	}
	
	// 1.5 ready
	function RSgetComponentTypeIdByName($componentName,$formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		
		$db = JFactory::getDBO();
		$componentName = $db->getEscaped($componentName);
		
		$db->setQuery("SELECT #__rsform_components.ComponentTypeId FROM #__rsform_components LEFT JOIN #__rsform_properties ON #__rsform_properties.ComponentId = #__rsform_components.ComponentId WHERE #__rsform_properties.PropertyName='NAME' AND #__rsform_properties.PropertyValue='".$componentName."' AND #__rsform_components.FormId='".$formId."'");
		
		return $db->loadResult();
	}

	// 1.5 ready
	function RSgetFileDestination($componentName,$formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$componentId=RSresolveComponentName($componentName,$formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT PropertyValue FROM #__rsform_properties WHERE PropertyName='DESTINATION' AND ComponentId='".$componentId."'");
		
		return $db->loadResult();
	}
	
	// 1.5 ready
	function RScomponentExists($formId,$componentTypeId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		$componentTypeId = intval($componentTypeId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT ComponentId FROM #__rsform_components WHERE ComponentTypeId='".$componentTypeId."' AND FormId='".$formId."' AND Published='1'");
		$rez = $db->loadAssocList();
		
		$output=array();
		foreach ($rez as $r)
			$output[] = $r['ComponentId'];
		
		return $output;
	}

	// 1.5 ready
	function RSgenerateString($length, $characters, $type='Random')
	{
		if($type == 'Random')
		{
			switch($characters)
			{
				case 'ALPHANUMERIC':
				default:
			  		$possible = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
				case 'ALPHA':
					$possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
				case 'NUMERIC':
					$possible = "0123456789";
				break;
			}

			if($length<1||$length>255) $length = 8;
			  $key = "";
			  $i = 0;
			  while ($i < $length) {
			    $key .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			    $i++;
			  }
		}
		if($type == 'Sequential')
		{

		}
		return $key;
	}

	// 1.5 ready
	function RSprocessField($result,$submissionId)
	{
		$db = JFactory::getDBO();
		$RSadapter=$GLOBALS['RSadapter'];
		$submissionId = intval($submissionId);
		
		//get submission details
		$Submission = RSgetSubmission($submissionId);
		
		//initialize placeholder and value arrays
		$placeholders = array();
		$values = array();
		
		//load form components
		$db->setQuery("SELECT ComponentId FROM #__rsform_components WHERE FormId = '".$Submission->FormId."' AND Published = 1");
		$ComponentRows = $db->loadObjectList();
		
		foreach($ComponentRows as $ComponentRow)
		{
			$properties = RSgetComponentProperties($ComponentRow->ComponentId);

			//{component:caption}
			$placeholders[] = '{'.$properties['NAME'].':caption'.'}';
			$values[] = isset($properties['CAPTION']) ? $properties['CAPTION'] : '';
			
			//{component:name}
			$placeholders[] = '{'.$properties['NAME'].':name'.'}';
			$values[] = $properties['NAME'];
			
			//{component:value}
			$placeholders[] = '{'.$properties['NAME'].':value'.'}';
			$properties['NAME'] = $db->getEscaped($properties['NAME']);
			$SubmissionValue = '';
			if(!empty($Submission->values))
				foreach($Submission->values as $SubmissionValueObj)
					if($SubmissionValueObj->FieldName == $properties['NAME'])
						$SubmissionValue = $SubmissionValueObj->FieldValue;
						
			if ($SubmissionValue !== '' && RSgetComponentTypeId($ComponentRow->ComponentId)==9) $SubmissionValue = basename($SubmissionValue);
			$values[] = $SubmissionValue;
		}
		
		$user = JFactory::getUser($Submission->UserId);
		if (empty($user->id))
		{
			$user = new stdClass();
			$user->id = 0;
			$user->username = '';
			$user->email = '';
			$user->name = '';
		}
		
		array_push($placeholders, '{global:username}', '{global:userid}', '{global:useremail}', '{global:fullname}', '{global:userip}', '{global:date_added}', '{global:sitename}', '{global:siteurl}');
		array_push($values, $user->username, $user->id, $user->email, $user->name, $_SERVER['REMOTE_ADDR'], $Submission->DateSubmitted, $RSadapter->config['sitename'], $RSadapter->config['live_site']);
		
		$result = str_replace($placeholders,$values,$result);

		return $result;
	}
	
	// 1.5 ready
	function RSgetSubmission($SubmissionId)
	{
		$db = JFactory::getDBO();
		
		//get submission 
		$db->setQuery("SELECT * FROM #__rsform_submissions WHERE SubmissionId = '".$SubmissionId."'");
		$Submission = $db->loadObject();
		
		//get submission details
		$db->setQuery("SELECT * FROM #__rsform_submission_values WHERE SubmissionId = '".$SubmissionId."'");
		$Submission->values = $db->loadObjectList();
		
		return $Submission;
	}

	// 1.5 ready
	function RSgetFormLayoutName($formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT FormLayoutName FROM #__rsform_forms WHERE FormId='".$formId."'");
		
		return $db->loadResult();
	}

	// 1.5 ready
	function RSreturnCheckedLayoutName($formId,$layoutName)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT FormLayoutName FROM #__rsform_forms WHERE FormId='".$formId."'");
		
		if ($db->loadResult() == $layoutName) return true;
		return false;
	}

	// 1.5 ready
	function RScopyForm($formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$formId = intval($formId);
		
		$db = JFactory::getDBO();
		$db->setQuery("INSERT INTO #__rsform_forms (`FormName`,`FormLayout`,`FormLayoutName`,`FormLayoutAutogenerate`,`FormTitle`,`Published`,`Lang`,`ReturnUrl`,`Thankyou`,`UserEmailText`,`UserEmailTo`,`UserEmailCC`,`UserEmailBCC`,`UserEmailFrom`,`UserEmailReplyTo`,`UserEmailFromName`,`UserEmailSubject`,`UserEmailMode`,`UserEmailAttach`,`UserEmailAttachFile`,`AdminEmailText`,`AdminEmailTo`,`AdminEmailCC`,`AdminEmailBCC`,`AdminEmailFrom`,`AdminEmailReplyTo`,`AdminEmailFromName`,`AdminEmailSubject`,`AdminEmailMode`,`ScriptProcess`,`ScriptProcess2`,`ScriptDisplay`) SELECT `FormName`,`FormLayout`,`FormLayoutName`,`FormLayoutAutogenerate`,`FormTitle`,`Published`,`Lang`,`ReturnUrl`,`Thankyou`,`UserEmailText`,`UserEmailTo`,`UserEmailCC`,`UserEmailBCC`,`UserEmailFrom`,`UserEmailReplyTo`,`UserEmailFromName`,`UserEmailSubject`,`UserEmailMode`,`UserEmailAttach`,`UserEmailAttachFile`,`AdminEmailText`,`AdminEmailTo`,`AdminEmailCC`,`AdminEmailBCC`,`AdminEmailFrom`,`AdminEmailReplyTo`,`AdminEmailFromName`,`AdminEmailSubject`,`AdminEmailMode`,`ScriptProcess`,`ScriptProcess2`,`ScriptDisplay` FROM #__rsform_forms WHERE #__rsform_forms.FormId='".$formId."'");
		
		$db->query();
		$newFormId = $db->insertid();

		$db->setQuery("UPDATE #__rsform_forms SET FormName=CONCAT(FormName,' copy'), FormTitle=CONCAT(FormTitle,' copy') WHERE FormId='".$newFormId."'");
		$db->query();
		
		$db->setQuery("SELECT * FROM #__rsform_components WHERE FormId='".$formId."'");
		$components = $db->loadAssocList();
		
		foreach ($components as $r)
		{
			$componentId=$r['ComponentId'];
			
			$db->setQuery("INSERT INTO #__rsform_components SET `FormId`='".$newFormId."', `ComponentTypeId`='".$r['ComponentTypeId']."', `Order`='".$r['Order']."'");
			$db->query();
			
			$newComponentId=$db->insertid();

			$db->setQuery("SELECT * FROM #__rsform_properties WHERE ComponentId='".$componentId."'");
			$properties = $db->loadAssocList();
			foreach ($properties as $p)
			{
				$db->setQuery("INSERT INTO #__rsform_properties SET PropertyName='".$db->getEscaped($p['PropertyName'])."', PropertyValue='".$db->getEscaped($p['PropertyValue'])."', ComponentId='".$newComponentId."'");
				$db->query();
			}
		}
	}

	// 1.5 ready
	function RScopyComponent($sourceComponentId,$destinationFormId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$sourceComponentId = intval($sourceComponentId);
		$destinationFormId = intval($destinationFormId);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__rsform_components WHERE ComponentId='".$sourceComponentId."'");
		$r = $db->loadAssoc();
		
		//get max ordering
		$db->setQuery("SELECT MAX(`Order`)+1 FROM #__rsform_components WHERE FormId = '".$destinationFormId."'");
		$r['Order'] = $db->loadResult();
		
		$db->setQuery("INSERT INTO #__rsform_components SET `FormId`='".$destinationFormId."', `ComponentTypeId`='".$r['ComponentTypeId']."', `Order`='".$r['Order']."',`Published`='".$r['Published']."'");
		$db->query();
		$newComponentId=$db->insertid();
		
		$db->setQuery("SELECT * FROM #__rsform_properties WHERE ComponentId='".$sourceComponentId."'");
		$properties = $db->loadAssocList();
		
		foreach ($properties as $r)
		{
			if ($r['PropertyName'] == 'NAME') $r['PropertyValue'] .= ' copy';
			$db->setQuery("INSERT INTO #__rsform_properties SET ComponentId='".$newComponentId."', PropertyName='".$r['PropertyName']."', PropertyValue='".$db->getEscaped($r['PropertyValue'])."'");
			$db->query();
		}
	}

	// 1.5 ready
	function RSlistComponents($formId)
	{
		$RSadapter=$GLOBALS['RSadapter'];
		$db = &JFactory::getDBO();
		$formId = intval($formId);
		
		$components=array();
		$db->setQuery("SELECT #__rsform_properties.PropertyValue, #__rsform_components.ComponentTypeId FROM #__rsform_properties LEFT JOIN #__rsform_components ON #__rsform_components.ComponentId = #__rsform_properties.ComponentId WHERE #__rsform_components.FormId='".$formId."' AND #__rsform_components.Published='1' AND #__rsform_properties.PropertyName='NAME' AND #__rsform_components.ComponentTypeId IN ('".implode("','",$RSadapter->config['component_ids'])."') ORDER BY #__rsform_components.`Order`");
		$components = $db->loadObjectList();
		
		return $components;
	}


function RSbackupCreateXMLfile($option, $formIds, $submissions, $files, $filename)
{
	$db = &JFactory::getDBO();
	$RSadapter=$GLOBALS['RSadapter'];
	$user = JFactory::getUser();

    //create the xml file
$xml =
'<?xml version="1.0" encoding="utf-8"?>
<RSinstall type="rsformbackup">
<name>RSform backup</name>
<creationDate></creationDate>
<author></author>
<copyright></copyright>
<authorEmail></authorEmail>
<authorUrl></authorUrl>
<version>'._RSFORM_VERSION.'</version>
<description>RSform Backup</description>
<tasks></tasks>
</RSinstall>';
    $xml = str_replace('<creationDate></creationDate>','<creationDate>'.date('Y-m-d').'</creationDate>',$xml);
    $xml = str_replace('<author></author>','<author>'.$user->username.'</author>',$xml);
    $xml = str_replace('<copyright></copyright>','<copyright> (C) '.date('Y').' '.$RSadapter->config['live_site'].'</copyright>',$xml);
    $xml = str_replace('<authorEmail></authorEmail>','<authorEmail>'.$RSadapter->config['mail_from'].'</authorEmail>',$xml);
    $xml = str_replace('<authorUrl></authorUrl>','<authorUrl>'.$RSadapter->config['live_site'].'</authorUrl>',$xml);

    $tasks = array();

    //LOAD FORMS
    
    $db->setQuery("SELECT * FROM #__rsform_forms WHERE FormId IN ('".implode("','",$formIds)."') ORDER BY FormId");
    $form_rows = $db->loadObjectList();
    foreach($form_rows as $form_row)
    {
         $tasks[] = RSxmlReturnQuery('#__rsform_forms',$form_row,'FormId');
         $tasks[] = '<task type="eval" source="">$GLOBALS[\'q_FormId\'] = $db->insertid();</task>';
         
         //LOAD COMPONENTS
	    $db->setQuery("SELECT * FROM #__rsform_components WHERE FormId = '".$form_row->FormId."'");
	    $component_rows = $db->loadObjectList();
	    foreach($component_rows as $component_row)
	    {
	         $tasks[] = RSxmlReturnQuery('#__rsform_components',$component_row,'ComponentId','FormId');
	         $tasks[] = '<task type="eval" source="">$GLOBALS[\'q_ComponentId\'] = $db->insertid();</task>';
	         
	             //LOAD PROPERTIES
			    $db->setQuery("SELECT * FROM #__rsform_properties WHERE ComponentId = '".$component_row->ComponentId."'");
			    $property_rows = $db->loadObjectList();
			    foreach($property_rows as $property_row)
			    {
			         $tasks[] = RSxmlReturnQuery('#__rsform_properties',$property_row,'PropertyId','ComponentId');
			    }
	    }
	    
	    
	    if($submissions)
		{
		    //LOAD SUBMISSIONS
		    $db->setQuery("SELECT * FROM #__rsform_submissions WHERE FormId = '".$form_row->FormId."'");
		    $submission_rows = $db->loadObjectList();
		    foreach($submission_rows as $submission_row)
		    {
				$tasks[] = RSxmlReturnQuery('#__rsform_submissions',$submission_row,'SubmissionId','FormId');
				$tasks[] = '<task type="eval" source="">$GLOBALS[\'q_SubmissionId\'] = $db->insertid();</task>';
 
				//LOAD SUBMISSION_VALUES
				$db->setQuery("SELECT * FROM #__rsform_submission_values WHERE SubmissionId = '".$submission_row->SubmissionId."'");
				$submission_value_rows = $db->loadObjectList();
				foreach($submission_value_rows as $submission_value_row)
			    {
			         $tasks[] = RSxmlReturnQuery('#__rsform_submission_values',$submission_value_row,'SubmissionValueId',array('SubmissionId', 'FormId'));
			         //echo '<p>'.RSxmlReturnQuery('#__rsform_submission_values',$submission_value_row,'SubmissionValueId','SubmissionId').'</p>';
			         
			    }
			   // die();
			    
		    }
		}
    }
    
    
    
/*
    if(defined('_RSFORM_PLUGIN_MAPPINGS'))
    {
	    //LOAD MAPPINGS
	    $query = mysql_query("SELECT * FROM `{$RSadapter->tbl_rsform_mappings}`");
	    while($component_row = mysql_fetch_array($query,MYSQL_ASSOC))
	    {
	         $tasks[] = RSxmlReturnQuery($RSadapter->tbl_rsform_mappings,$component_row);
	    }
    }
*/
    $task_html = implode("\r\n",$tasks);
    $xml = str_replace('<tasks></tasks>','<tasks>'."\r\n".$task_html."\r\n".'</tasks>',$xml);

    //echo $xml;die();
    //write the file
    //touch($filename);
    if (!$handle = fopen($filename, 'w')) exit;
    if (fwrite($handle, $xml) === FALSE) exit;
    fclose($handle);
}



function RSxmlReturnQuery($tb_name, $row, $exclude = null, $dynamic = null)
{

    $fields = array();
    $values = array();

	$db = JFactory::getDBO();
	
    foreach($row as $k=>$v) {
        $fields[] = '`' . $k . '`';
        if($k == $exclude) $v = "";
		if (is_array($dynamic))
		{
			if (in_array($k, $dynamic))
				$v = "{".$dynamic[array_search($k, $dynamic)]."}";
		}
		else
			if($k == $dynamic) $v = "{".$dynamic."}";
        $values[] = "'" . $db->getEscaped($v) . "'";
    }

    $xml = 'INSERT INTO `' . $tb_name . '` (' . implode(',',$fields) . ') VALUES (' . implode(',',$values) . ' )';
    //$xml = str_replace("\r",'',$xml);
    //$xml = str_replace("\n",'\\n',$xml);

    return "\t".'<task type="query"><![CDATA['.$xml.']]></task>';
}

function RSxmlentities($string, $quote_style=ENT_QUOTES)
{
    static $trans;
    if (!isset($trans)) {
        $trans = get_html_translation_table(HTML_ENTITIES, $quote_style);
        foreach ($trans as $key => $value)
            $trans[$key] = '&#'.ord($key).';';
        // dont translate the '&' in case it is part of &xxx;
        //$trans[chr(38)] = '&';
    }
    // after the initial translation, _do_ map standalone '&' into '&#38;'
    return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/","&#38;" , strtr($string, $trans));
}/*
function RSxmlentities ( $string, $null )
{
    return str_replace ( array ( '&', '"', "'", '<', '>' ), array ( '&amp;' , '&quot;', '&apos;' , '<' , '>' ), $string );
}
*/
function RSRmkdir($path)
{
    $exp=explode("/",$path);
    $way='';
    foreach($exp as $n){
        $way.=$n.'/';
        if(!file_exists($way))
            @mkdir($way);
    }
}

function RSuploadFile( $filename, $userfile_name, &$msg )
{
    $RSadapter=$GLOBALS['RSadapter'];
    $baseDir = $RSadapter->processPath( $RSadapter->config['absolute_path'] . '/media' );

    if (file_exists( $baseDir )) {
        if (is_writable( $baseDir )) {
            if (move_uploaded_file( $filename, $baseDir . $userfile_name )) {
            	$RSadapter->chmod( $baseDir . $userfile_name );
            	return true;/*
                if () {

                } else {
                    $msg = 'Failed to change the permissions of the uploaded file.';
                }*/
            } else {
                $msg = 'Failed to move uploaded file to <code>/media</code> directory.';
            }
        } else {
            $msg = 'Upload failed as <code>/media</code> directory is not writable.';
        }
    } else {
        $msg = 'Upload failed as <code>/media</code> directory does not exist.'.$baseDir;
    }
    return false;
}


function RSprocessTask($option, $task, $uploaddir, $version){
    //$type,$value,$dest
    $RSadapter=$GLOBALS['RSadapter'];

    $type    	= $task->getAttribute('type');
    $source    	= $task->getAttribute('source');
    $value   	= $task->getText();
    
	$db = JFactory::getDBO();
	
    //$source 	= eval('return "'.$source.'";');
    //$value	= eval('return "'.$value.'";');
     
    switch ($type){
        case 'mkdir':
            RSRmkdir($RSadapter->config['absolute_path'].$value);
            //echo 'MKDIR OK '.$value;
            return true;
        break;
        case 'query':
        	$value = str_replace('{PREFIX}',$RSadapter->config['dbprefix'], $value);
        	if(isset($GLOBALS['q_FormId'])) $value = str_replace('{FormId}',$GLOBALS['q_FormId'], $value);
        	if(isset($GLOBALS['q_ComponentId'])) $value = str_replace('{ComponentId}',$GLOBALS['q_ComponentId'], $value);
        	if(isset($GLOBALS['q_SubmissionId'])) $value = str_replace('{SubmissionId}',$GLOBALS['q_SubmissionId'], $value);
			// Little hack to rename all uppercase tables to new lowercase format
			preg_match('/INSERT INTO `'.$RSadapter->config['dbprefix'].'(\w+)`/',$value,$matches);
			if (count($matches) > 0 && isset($matches[1]))
				$value = str_replace($matches[1],strtolower($matches[1]),$value);
			// End of hack
			if ($version != '1.2.0')
				$value = html_entity_decode($value);
			
			$db->setQuery($value);
        	if ($db->query())
        	{
                return true;
            }else{
                echo 'QUERY ERROR '.$value."<br/>";
                return false;
            }

        break;
        case 'copy':
            if($value!=''){

                $rfile = @fopen ($uploaddir.$source, "r");
                if (!$rfile) {
                    echo 'FOPEN ERROR '.$uploaddir.$source.". Make sure the file exists.<br/>";
                    return false;
                }else{
                    $filecontents = @fread($rfile, filesize($uploaddir.$source));
                    $filename = $RSadapter->config['absolute_path'].'/'.$value;

                    //check if folder exists, else mkdir it.
                    $path = str_replace('\\','/',$filename);
                    $path = explode('/',$path);
                    unset($path[count($path)-1]);
                    $path = implode('/',$path);
                    if(!is_dir($path)) RSRmkdir($path);
					@chmod($path,0777);
                    if (!$handle = @fopen($filename, 'w')) {
                        echo 'FWRITE OPEN ERROR '.$filename.". Make sure there are write permissions (777)<br/>";
                        return false;
                        // exit;
                    }

                    // Write $filecontents to our opened file.
                    if (fwrite($handle, $filecontents) === FALSE) {
                        echo 'FWRITE ERROR '.$filename.". Make sure there are write permissions (777)<br/>";
                        return false;
                    }
                    //echo 'COPY OK '.$value;
                    return true;

                    fclose($handle);
                }
            }
        break;
        case 'rename':
        	if($value!=''){
        		$oldfile = $uploaddir.$source;
        		$newfile = $RSadapter->config['absolute_path'].'/'.$value;
        		$rename = @rename($oldfile,$newfile);
        		if(!$rename){
        			 echo 'RENAME ERROR '.$newfile."<br/>";
                     return false;
        		}
        	}
        break;
        case 'eval':
			if (strpos($value, '$GLOBALS[\'q_ComponentId\'] = mysql_insert_id();') !== false
			|| strpos($value, '$GLOBALS[\'q_SubmissionId\'] = mysql_insert_id();') !== false
			|| strpos($value, '$GLOBALS[\'q_FormId\'] = mysql_insert_id();') !== false)
				$value = str_replace('mysql_insert_id','$db->insertid',$value);
        	eval($value);
        	return true;
        break;
        case 'delete':
            $filename = $RSadapter->config['absolute_path'].$value;
            if(file_exists($filename)){
                if(is_dir($filename)){
                    rmdir($filename);
                }else{
                    unlink($filename);
                }
                //echo 'DELETE OK '.$value;
                return true;
            }else{
                echo 'DELETE ERROR '.$value."<br/>";
                return false;
            }
        break;

    }
}


function RSparse_mysql_dump($file)
{
	$RSadapter=$GLOBALS['RSadapter'];
	$message = '';

	$db = JFactory::getDBO();
	
	$file_content = file($file);
	foreach($file_content as $sql_line)
	{
		if(trim($sql_line) != "" && strpos($sql_line, "--") === false)
		{
			$sql_line = str_replace('{PREFIX}',$RSadapter->config['dbprefix'], $sql_line);
			$db->setQuery($sql_line);
			if (!$db->query())
				$message .= '<pre>'.$sql_line.mysql_error().'</pre><br/>';
	 	}
	}

	if($message == '') return 'ok';
	else return $message;
}

 function RSreadfile_chunked($filename,$retbytes=true)
 {
	$chunksize = 1*(1024*1024); // how many bytes per chunk
	$buffer = '';
	$cnt =0;
	$handle = fopen($filename, 'rb');
	if ($handle === false) {
		return false;
	}
	while (!feof($handle)) {
		$buffer = fread($handle, $chunksize);
		echo $buffer;
		if ($retbytes) {
			$cnt += strlen($buffer);
		}
	}
	$status = fclose($handle);
	if ($retbytes && $status) {
		return $cnt; // return num. bytes delivered like readfile() does.
	}
	return $status;
}

//PLUGINS
function RSmappingsBuyWriteTab()
{
	$RSadapter=$GLOBALS['RSadapter'];
	?>
      <tr>
          	<td valign="top" align="left" colspan="3">
          		<?php echo _RSFORM_BACKEND_FORMS_EDIT_MAPPINGS_BUY_DESC;?>
			</td>
		</tr>
    <?php
}


?>