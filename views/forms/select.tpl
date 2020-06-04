[+assign var=id value=$id|default:$name+]
[+assign var=placeholder value=$placeholder|default:$label+]
[+assign var=disabled value=$disabled|default:''+]
[+assign var=onchange value=$onchange|default:false+]
[+assign var=placeholder value=$placeholder|default:false+]
[+assign var=col value=$col|default:false+]
[+assign var=readonly value=$readonly|default:false+]
[+assign var=not_empty value=$not_empty|default:false+]
[+assign var=class value=$class|default:''+]
[+if $form +]
	[+if !isset($value) +]
		[+assign var=value value=$form->$name+]
	[+/if+]
	[+assign var=error value=$error|default:$form->getError($name)+]
	[+*assign var=required value=$required|default:$form->isRequired($name)*+]
[+/if+]
<div class="form-group col[+if $col+]-[+$col+][+/if+]">
	[+if $label+]<label for="[+$id+]" class="col-form-label[+if $required+] required[+/if+]">[+$label+]</label>[+/if+]
	<select [+if $id+]id="[+$id+]"[+/if+] name="[+$name+]" class="custom-select [+$class+][+if $error+] is-invalid[+/if+]"[+if $placeholder+] placeholder="[+$placeholder+]"[+/if+][+if $disabled+] disabled[+/if+][+if $required+] required[+/if+][+if $onchange+] onchange="[+$onchange+]"[+/if+]>
		[+if !$not_empty && !$readonly+]<option></option>[+/if+]
	[+foreach from=$choices item=obj key=v+]
		[+if ($readonly && ((is_object($obj) && $obj->id==$value) || (!is_object($obj) && $v==$value))) || !$readonly+]
		<option value="[+if is_object($obj)+][+$obj->id+][+else+][+$v+][+/if+]" [+if is_object($obj)+][+if $obj->id==$value+]selected[+/if+][+else+][+if $v==$value+]selected[+/if+][+/if+]>[+*$obj->*+]</option>
		[+/if+]
	[+/foreach+]
	</select>
	[+if $error+]
	<div class="invalid-feedback">[+$error+]</div>
	[+/if+]
</div>
