[+$TABLEVIEW->getTitle()+]

<div class="card-body">

<input type="hidden" name="view" value="[+*$viewClass*+]"/>
<input type="hidden" name="controller" value="[+*$current_controller*+]"/>
<input type="hidden" name="action" value="exec"/>

<div class="form-row">
	<div class="table-responsive">
		<table class="table table-striped table-dark">
			<thead>
				<tr>
					[+foreach from=$TABLEVIEW->getHeaderFields() name=headers item=header +]
						<th scope="col">[+$header+]</th>
					[+/foreach+]
				</tr>
			</thead>

			[+foreach from=$TABLEVIEW->getRows() name=rows item=row+]
				[+if $TABLEVIEW->getRowTemplate() +]
					<tr>
						[+include file=$TABLEVIEW->getRowTemplate()+]
					
					[+if $TABLEVIEW->getItemActions()+]
						<td class="itemActions">
						[+foreach from=$TABLEVIEW->getItemActions() name=actions item=action+]
							<a class="" href="[+$action->url+]?id=[+$row.id+]" title="[+if $action->title+][+$action->title+][+else+][+$action->label+][+/if+]" onclick="[+$action->onclick+]">
								<span class="fa fa-[+$action->class+]"></span>
								[+*$action->label*+]
							</a>
						[+/foreach+]
						</td>
					[+/if+]
					</tr>
				[+/if+]
			[+/foreach+]
		</table>
	</div>
</div>