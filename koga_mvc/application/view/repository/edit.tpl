  <form method="post" action="?mode=repository&action=edit" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">格納場所</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.repository_storage_id}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">コンテンツ</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.repository_contents_id}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">運営会社</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.repository_company_id}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">種別</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.repository_type_id}</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">リポジトリ名</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.name}</span>
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
