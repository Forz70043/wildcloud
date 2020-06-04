[+if isset($notice)+]
<div id="notice" class="row">
	<div class="col text-center">
	[+if $notice->hasSuccess()+]
		[+foreach item=notice from=$notice->getSuccess()+]
		<p class="alert alert-success alert-dismissible fade show">
		<span class="fa fa-check-circle float-left" style="font-size: 1.5rem;"></span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
		[+$notice nofilter+]
		</p>
		[+/foreach+]
	[+/if+]
	[+if $notice->hasWarning()+]
		[+foreach item=notice from=$notice->getWarning()+]
		<p class="alert alert-warning alert-dismissible fade show">
		<span class="fa fa-exclamation-circle float-left" style="font-size: 1.5rem;"></span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
		[+$notice nofilter+]
		</p>
		[+/foreach+]
	[+/if+]
	[+if $notice->hasError()+]
		[+foreach item=notice from=$notice->getError()+]
		<p class="alert alert-danger alert-dismissible fade show">
		<span class="fa fa-times-circle float-left" style="font-size: 1.5rem;"></span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
		[+$notice nofilter+]
		</p>
		[+/foreach+]
	[+/if+]
	</div>
</div>
[+/if+]