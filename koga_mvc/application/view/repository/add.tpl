  {if $error_flg != 0}
  {foreach from=$error_ary item=string}
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert">×</button>
    {$string}
  </div>
  {/foreach}
  {/if}
  <form method="post" action="?mode=repository&action=add" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">格納場所</label>
      <div class="controls">
        <select name="repository_storage_id">
          {foreach from=$etc_data.storage_data item=name key=id}
          <option value="{$id}">{$name}</option>
          {/foreach}
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">コンテンツ</label>
      <div class="controls">
        <select name="repository_contents_id">
          {foreach from=$etc_data.contents_data item=name key=id}
          <option value="{$id}">{$name}</option>
          {/foreach}
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">運営会社</label>
      <div class="controls">
        <select name="repository_company_id">
          {foreach from=$etc_data.company_data item=name key=id}
          <option value="{$id}">{$name}</option>
          {/foreach}
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">種別</label>
      <div class="controls">
        <select name="repository_type_id">
          {foreach from=$etc_data.type_data item=name key=id}
          <option value="{$id}">{$name}</option>
          {/foreach}
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">リポジトリ名</label>
      <div class="controls">
        <input type="text" name="name" class="span3">
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
