[+assign var=id value=$id|default:$name+]
[+assign var=name value=$name|default:''+]
[+assign var=type value=$type|default:'input'+]
[+assign var=class value=$class|default:''+]
[+assign var=placeholder value=$placeholder|default:$label+]
[+if $ariadescribe+]
	[+assign var=ariadescribeText value=$ariadescribeText|default:''+]
[+/if+]

<div class="form-group col[+if $col+]-[+$col+][+/if+]">
	<label for="[+$name+]">[+$label+]</label>
    <input type="[+$type+]" class="form-control [+$class+]" id="[+$id+]" name="[+$name+]" [+if $ariadescribe+]aria-describedby="[+$ariadescribeName+]" [+/if+] placeholder="[+$placeholder+]" [+if $required+]required[+/if+] [+if $onclick+]onclick="[+$onclick+]"[+/if+] [+if $onchange+]onchange="[+$onchange+]"[+/if+] [+if $readonly+]readonly[+/if+] />
    <small id="[+$ariadescribeName+]" class="form-text text-muted">[+$ariadescribeText+]</small>
 </div>