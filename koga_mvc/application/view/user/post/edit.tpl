  {if $error_flg != 0}
  {foreach from=$error_ary item=string}
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert">×</button>
    {$string}
  </div>
  {/foreach}
  {/if}
  <form method="post" action="?mode=user::post&action=edit" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">略称</label>
      <div class="controls">
        <input type="text" name="code" class="span6" value="{$data.code}">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">部署名</label>
      <div class="controls">
        <input type="text" name="name" class="span6" value="{$data.name}">
      </div>
    </div>
    <div class="form-actions">
      <input type="hidden" name="id" value="{$data.id}">
      <input type="submit" name="submit" class="btn btn-primary" value="編集">
    </div>
  </form>
