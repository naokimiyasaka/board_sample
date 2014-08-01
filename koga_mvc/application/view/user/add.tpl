  {if $error_flg != 0}
  {foreach from=$error_ary item=string}
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert">×</button>
    {$string}
  </div>
  {/foreach}
  {/if}
  <form method="post" action="?mode=user&action=add" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">部署</label>
      <div class="controls">
        <select name="user_post_id">
          {foreach from=$etc_data.post_data item=name key=id}
          <option value="{$id}">{$name}</option>
          {/foreach}
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">名前</label>
      <div class="controls">
        <input type="text" name="name" class="span3">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">メールアドレス</label>
      <div class="controls">
        <input type="text" name="email" class="span6">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">コミットメール受け取り</label>
      <div class="controls">
        {foreach from=$etc_data.repository_data item=data}
        <label class="checkbox">
          <input type="checkbox" name="repository{$data.id}" value="1">{$data.path}
        </label>
        {/foreach}
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" class="btn btn-primary" value="登録">
    </div>
  </form>
