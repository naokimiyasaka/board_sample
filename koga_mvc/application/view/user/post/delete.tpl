  <form method="post" action="?mode=user::post&action=delete" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">略称</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.code}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">部署名</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.name}</span>
      </div>
    </div>
    <div class="form-actions">
      <input type="hidden" name="id" value="{$data.id}">
      <input type="submit" name="submit" class="btn btn-danger" value="削除">
    </div>
  </form>
