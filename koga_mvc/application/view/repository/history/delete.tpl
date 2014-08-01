  <form method="post" action="?mode=repository::history&action=delete" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">バージョン</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.release_version}</span>
        <p class="help-block">運営が決めたユーザーに公開するバージョン</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">開発番号</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.development_version}</span>
        <p class="help-block">開発とやり取りするバージョンコード。日付_その日のパッチ数の書式で書くこと。例)<code>20120605_01</code></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">内容</label>
      <div class="controls">
        <textarea name="note" class="span6 disabled" rows="5" disabled>{$data.note}</textarea>
        <p class="help-block">パッチの内容説明</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">希望日</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.preferred_date}</span>
        <p class="help-block">パッチの納品希望日</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">納品日</label>
      <div class="controls">
        {if $data.delivery_date == '0000-00-00'}
        <span class="input-xlarge uneditable-input">----</span>
        {else}
        <span class="input-xlarge uneditable-input">{$data.delivery_date}</span>
        {/if}
        <p class="help-block">実際のパッチ納品日</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">テスト Revision</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.test_revision}</span>
        <p class="help-block">StagingのRevision番号</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">本番 Revision</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.release_revision}</span>
        <p class="help-block">ProductionのRevision番号</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">適用サーバー</label>
      <div class="controls">
        <span class="input-xlarge uneditable-input">{$data.application_server}</span>
        <p class="help-block">適用するテストサーバー名</p>
      </div>
    </div>
    <div class="form-actions">
      <input type="hidden" name="id" value="{$data.id}">
      <input type="hidden" name="repository_id" value="{$data.repository_master_id}">
      <input type="submit" name="submit" class="btn btn-danger" value="削除">
    </div>
  </form>
