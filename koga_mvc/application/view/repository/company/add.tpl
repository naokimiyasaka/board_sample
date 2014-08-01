  {if $error_flg != 0}
  {foreach from=$error_ary item=string}
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert">×</button>
    {$string}
  </div>
  {/foreach}
  {/if}
  <form method="post" action="?mode=repository::company&action=add" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">略称</label>
      <div class="controls">
        <input type="text" name="code" class="span3">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">運営会社名</label>
      <div class="controls">
        <input type="text" name="name" class="span6">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">備考</label>
      <div class="controls">
        <input type="text" name="memo" class="span6">
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" class="btn btn-primary" value="登録">
    </div>
  </form>
