[+assign var=id value=$id|default:$name+]
[+assign var=name value=$name|default:''+]
[+assign var=class value=$class|default:''+]
[+assign var=placeholder value=$placeholder|default:$label+]
[+assign var=class value=$class|default:'form-check-input'+]
[+if $ariadescribe+]
	[+assign var=ariadescribeText value=$ariadescribeText|default:''+]
[+/if+]

<div class="form-check">
	<input class=[+$class+] type='checkbox' id=$id name=$name [+if $required+]required[+/if+] [+if $onclick+]onclick="[+$onclick+]"[+/if+] [+if $readonly+]readonly[+/if+] value=[+$value+]/>
	<label for=[+$name+] class='form-check-label'>
		[+$label+]
	</label>
</div>