  {if $error_flg != 0}
  {foreach from=$error_ary item=string}
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert">×</button>
    {$string}
  </div>
  {/foreach}
  {/if}
  <form method="post" action="?mode=user&action=edit" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">部署</label>
      <div class="controls">
        <select name="user_post_id">
          {foreach from=$etc_data.post_data item=name key=id}
          {if $id == $data.user_post_id}
          <option value="{$id}" selected>{$name}</option>
          {else}
          <option value="{$id}">{$name}</option>
          {/if}
          {/foreach}
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">名前</label>
      <div class="controls">
        <input type="text" name="name" class="span3" value="{$data.name}">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">メールアドレス</label>
      <div class="controls">
        <input type="text" name="email" class="span6" value="{$data.email}">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">コミットメール受け取り</label>
      <div class="controls">
        {foreach from=$etc_data.repository_data item=repo}
        <label class="checkbox">
          {if $repo.send_flg == 1}
          <input type="checkbox" name="repository{$repo.id}" value="1" checked>{$repo.path}
          {else}
          <input type="checkbox" name="repository{$repo.id}" value="1">{$repo.path}
          {/if}
        </label>
        {/foreach}
      </div>
    </div>
    <div class="form-actions">
      <input type="hidden" name="id" value="{$data.id}">
      <input type="submit" name="submit" class="btn btn-primary" value="編集">
    </div>
  </form>
