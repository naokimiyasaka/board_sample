  {if $error_flg != 0}
  {foreach from=$error_ary item=string}
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert">×</button>
    {$string}
  </div>
  {/foreach}
  {/if}
  <form method="post" action="?mode=repository::company&action=edit" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">略称</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.code}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">運営会社名</label>
      <div class="controls">
        <input type="text" name="name" class="span6" value="{$data.name}">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">備考</label>
      <div class="controls">
        <input type="text" name="memo" class="span6" value="{$data.memo}">
      </div>
    </div>
    <div class="form-actions">
      <input type="hidden" name="id" value="{$data.id}">
      <input type="submit" name="submit" class="btn btn-primary" value="編集">
    </div>
  </form>
