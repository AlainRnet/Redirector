<?php
defined('JPATH_BASE') or die;
class JFormFieldTextToLink extends JFormField {
	public function getInput() {
		$textstolinks = (Array)$this->value;
		$out = '
		<script>
			function SeoBangClosest(that, tagname) {
				var i = 0, tmp = that.parentNode;
				tagname = tagname.toLowerCase();
				while (tmp.tagName.toLowerCase()!=tagname && i++<5) {
					tmp = tmp.parentNode;
				}
				return tmp;
			}
			function SeoBangAfter(tr, tr2) {
				tr.parentNode.insertBefore(tr2, tr.nextSibling);
				SeoBangTextToLinkSort(SeoBangClosest(tr, "tbody"));
			}
			function SeoBangTextToLinkAdd(that) {
				var table = SeoBangClosest(that, "table"),
					tbody = table.getElementsByTagName("tbody")[0],
					tr = tbody.getElementsByTagName("tr")[0],
					clone = tr.cloneNode(true);
					
				SeoBangTextToLinkClear(clone.childNodes[0]);
				tbody.appendChild(clone);
				SeoBangTextToLinkSort(tbody);
			}
			function SeoBangTextToLinkCopy(that) {
				var tr = SeoBangClosest(that, "tr"),
					clone = tr.cloneNode(true),
					i = 0;
				SeoBangAfter(tr, clone);
			}
			function SeoBangTextToLinkClear(that) {
				var tr = SeoBangClosest(that, "tr");
				tr.getElementsByTagName("input")[0].value="";
				tr.getElementsByTagName("input")[1].value="";
			}
			function SeoBangTextToLinkRemove(that) {
				var tr = SeoBangClosest(that, "tr"),
					tbody = SeoBangClosest(tr, "tbody");
				if (tbody.getElementsByTagName("tr").length>1) {
					tr.parentNode.removeChild(tr);
					SeoBangTextToLinkSort(tbody);
				}
			}
			function SeoBangTextToLinkSort(tbody) {
				var trs = tbody.getElementsByTagName("tr"),
					i = 0,
					inputs;
				for (i = 0;i < trs.length;i+=1) {
					inputs = trs[i].getElementsByTagName("input"),
					inputs[0].name = inputs[0].name.replace(/\[[0-9]+\]/g,"["+i+"]")
					inputs[1].name = inputs[1].name.replace(/\[[0-9]+\]/g,"["+i+"]")
				}
			}
		</script>
		<table class="table table-striped table-bordered table-condensed">
			<thead>
				<tr>
					<th style="vertical-align:middle">'.JText::_('PLG_SYSTEM_REDIRECTOR_FROM').' <a onclick="SeoBangTextToLinkAdd(this)" title="'.JText::_('PLG_SYSTEM_REDIRECTOR_ADD_ITEM').'"  href="javascript:void(0);"><span style=";" class="icon-plus"></span></a></th>
					<th>'.JText::_('PLG_SYSTEM_REDIRECTOR_TO').'</th>
					<th>'.JText::_('PLG_SYSTEM_REDIRECTOR_MANAGE').'</th>
				</tr>
			</thead>
			<tbody>
		';
		foreach ($textstolinks as $k=>$value) {
			$out.='<tr>
					<td><input class="span12" type="text" name="'.$this->name.'['.$k.'][text]" value="'.$value['text'].'"></td>
					<td><input class="span12" type="url" name="'.$this->name.'['.$k.'][link]" value="'.$value['link'].'"></td>
					<td style="vertical-align:middle;">
						<a onclick="SeoBangTextToLinkCopy(this)" title="'.JText::_('PLG_SYSTEM_REDIRECTOR_COPY_ITEM').'"  href="javascript:void(0);"><span style=";" class="icon-copy"></span></a>
						<a onclick="SeoBangTextToLinkClear(this)" title="'.JText::_('PLG_SYSTEM_REDIRECTOR_CLEAR_ITEM').'" href="javascript:void(0);"><span style="" class="icon-delete"></span></a>
						<a onclick="SeoBangTextToLinkRemove(this)" title="'.JText::_('PLG_SYSTEM_REDIRECTOR_REMOVE_ITEM').'" href="javascript:void(0);"><span style="color: #bd362f;" class="icon-trash"></span></a>
					</td>
				</tr>';
		}
		return $out.'</tbody>
			</table>';
	}
}
