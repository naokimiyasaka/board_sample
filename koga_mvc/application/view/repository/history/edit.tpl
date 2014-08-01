  {if $error_flg != 0}
  {foreach from=$error_ary item=string}
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert">×</button>
    {$string}
  </div>
  {/foreach}
  {/if}
  <form method="post" action="?mode=repository::history&action=edit" class="well form-horizontal">
    <div class="control-group">
      <label class="control-label">バージョン</label>
      <div class="controls">
        <input type="text" name="release_version" class="span3" value="{$data.release_version}">
        <p class="help-block">運営が決めたユーザーに公開するバージョン</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">開発番号</label>
      <div class="controls">
        <input type="text" name="development_version" class="span3" value="{$data.development_version}">
        <p class="help-block">開発とやり取りするバージョンコード。日付_その日のパッチ数の書式で書くこと。例)<code>20120605_01</code></p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">内容</label>
      <div class="controls">
        <textarea name="note" class="span6" rows="5">{$data.note}</textarea>
        <p class="help-block">パッチの内容説明</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">希望日</label>
      <div class="controls">
        <div class="input-append">
          <select name="preferred_year" class="span2">
            {foreach from=$etc_data.year item=p_year}
            {if $p_year == $data.p_year}
            <option value="{$p_year}" selected>{$p_year}</option>
            {else}
            <option value="{$p_year}">{$p_year}</option>
            {/if}
            {/foreach}
          </select>
          <span class="add-on">年</span>
        </div>
        <div class="input-append">
          <select name="preferred_month" class="span1">
            {foreach from=$etc_data.month item=p_month}
            {if $p_month == $data.p_month}
            <option value="{$p_month}" selected>{$p_month}</option>
            {else}
            <option value="{$p_month}">{$p_month}</option>
            {/if}
            {/foreach}
          </select>
          <span class="add-on">月</span>
        </div>
        <div class="input-append">
          <select name="preferred_day" class="span1">
            {foreach from=$etc_data.day item=p_day}
            {if $p_day == $data.p_day}
            <option value="{$p_day}" selected>{$p_day}</option>
            {else}
            <option value="{$p_day}">{$p_day}</option>
            {/if}
            {/foreach}
          </select>
          <span class="add-on">日</span>
        </div>
        <p class="help-block">パッチの納品希望日</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">納品日</label>
      <div class="controls">
        <div class="input-append">
          <select name="delivery_year" class="span2">
            <option value="0">----</option>
            {foreach from=$etc_data.year item=d_year}
            {if $d_year == $data.d_year}
            <option value="{$d_year}" selected>{$d_year}</option>
            {else}
            <option value="{$d_year}">{$d_year}</option>
            {/if}
            {/foreach}
          </select>
          <span class="add-on">年</span>
        </div>
        <div class="input-append">
          <select name="delivery_month" class="span1">
            <option value="0">----</option>
            {foreach from=$etc_data.month item=d_month}
            {if $d_month == $data.d_month}
            <option value="{$d_month}" selected>{$d_month}</option>
            {else}
            <option value="{$d_month}">{$d_month}</option>
            {/if}
            {/foreach}
          </select>
          <span class="add-on">月</span>
        </div>
        <div class="input-append">
          <select name="delivery_day" class="span1">
            <option value="0">----</option>
            {foreach from=$etc_data.day item=d_day}
            {if $d_day == $data.d_day}
            <option value="{$d_day}" selected>{$d_day}</option>
            {else}
            <option value="{$d_day}">{$d_day}</option>
            {/if}
            {/foreach}
          </select>
          <span class="add-on">日</span>
        </div>
        <p class="help-block">実際のパッチ納品日</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">テスト Revision</label>
      <div class="controls">
        <input type="text" name="test_revision" class="span2" value="{$data.test_revision}">
        <p class="help-block">StagingのRevision番号</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">本番 Revision</label>
      <div class="controls">
        <input type="text" name="release_revision" class="span2" value="{$data.release_revision}">
        <p class="help-block">ProductionのRevision番号</p>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">適用サーバー</label>
      <div class="controls">
        <input type="text" name="application_server" class="span5" value="{$data.application_server}">
        <p class="help-block">適用するテストサーバー名</p>
      </div>
    </div>
    <div class="form-actions">
      <input type="hidden" name="id" value="{$data.id}">
      <input type="hidden" name="repository_id" value="{$data.repository_master_id}">
      <input type="submit" name="submit" class="btn btn-primary" value="編集">
    </div>
  </form>
