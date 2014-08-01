  <form method="post" action="?mode=user&action=delete" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">部署</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.user_post_id}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">名前</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.name}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">メールアドレス</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.email}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">コミットメール受け取り</label>
      <div class="controls">
        {foreach from=$etc_data.repository_data item=repo}
          {if $repo.send_flg == 1}
          <p class="help-block">{$repo.path}</p>
          {/if}
        {/foreach}
      </div>
    </div>
    <div class="form-actions">
      <input type="hidden" name="id" value="{$data.id}">
      <input type="submit" name="submit" class="btn btn-danger" value="削除">
    </div>
  </form>
