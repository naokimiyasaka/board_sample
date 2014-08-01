  <table class="table table-bordered table-bordered">
    <tr>
      <td><strong>トランク</strong></td>
      <td><strong>svn+ssh://127.167.180.69/var/svn/release/{$etc_data.storage_name}/{$etc_data.contents_name}/{$etc_data.company_name}/{$etc_data.type_name}/{$etc_data.repository_name}/trunk</strong></td>
    </tr>
    <tr>
      <td>ブランチ</td>
      <td>svn+ssh://127.167.180.69/var/svn/release/{$etc_data.storage_name}/{$etc_data.contents_name}/{$etc_data.company_name}/{$etc_data.type_name}/{$etc_data.repository_name}/branches</td>
    </tr>
    <tr>
      <td>タグ</td>
      <td>svn+ssh://127.167.180.69/var/svn/release/{$etc_data.storage_name}/{$etc_data.contents_name}/{$etc_data.company_name}/{$etc_data.type_name}/{$etc_data.repository_name}/tags</td>
    </tr>
  </table>
  <p><a href="?mode=repository::history&action=add&repository_id={$etc_data.repository_id}" class="btn btn-success"><i class="icon-plus icon-white"></i> パッチ履歴新規登録</a></p>
  <table class="table table-bordered" id="sorted-table">
    <thead>
      <tr style="background-color:#d9edf7; cursor: pointer;">
        <th class="type-string">バージョン</th>
        <th class="type-string">開発番号</th>
        <th class="type-string">内容</th>
        <th class="type-date">希望日</th>
        <th class="type-date">納品日</th>
        <th class="type-int">テストrev</th>
        <th class="type-int">本番rev</th>
        <th class="type-string">適用サーバー</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {foreach from=$data item=row}
      {if $row.invalid_flg == 1}
      <tr style="background-color:#ee5f5b">
      {else}
      <tr>
      {/if}
        <td>{$row.release_version}</td>
        <td>{$row.development_version}</td>
        <td id="note{$row.id}">{$row.note_sub}
        <script type="text/javascript">
          $('#note'+{$row.id}).popover(
            {literal}
            {
            {/literal}
              animation: false,
              title: "パッチ内容",
              content: '{$row.note}'
            {literal}
            }
            {/literal}
          );
        </script></td>
        <td>{$row.preferred_date}</td>
        <td>{$row.delivery_date}</td>
        <td>{$row.test_revision}</td>
        <td>{if $row.release_revision == 0}&nbsp;{else}{$row.release_revision}{/if}</td>
        <td id="server{$row.id}">{$row.application_server_sub}
        <script type="text/javascript">
          $('#server'+{$row.id}).popover(
            {literal}
            {
            {/literal}
              animation: false,
              title: "適用サーバー",
              placement: 'left',
              content: '{$row.application_server}'
            {literal}
            }
            {/literal}
          );
        </script></td>
        <td><a href="?mode=repository::history&action=edit&id={$row.id}" class="btn"><i class="icon-pencil"></i> 編集</a></td>
        {if $row.invalid_flg == 0}
        <td><a href="?mode=repository::history&action=invalid&id={$row.id}&repository_id={$row.repository_master_id}" class="btn btn-warning"><i class="icon-trash icon-white"></i> 破棄</a></td>
        {else}
        <td><a href="?mode=repository::history&action=invalid&id={$row.id}&repository_id={$row.repository_master_id}" class="btn btn-primary"><i class="icon-thumbs-up icon-white"></i> 復活</a></td>
        {/if}
        <td><a href="?mode=repository::history&action=delete&id={$row.id}" class="btn btn-danger"><i class="icon-remove icon-white"></i> 削除</a></td>
      </tr>
      {/foreach}
    </tbody>
  </table>
  <p><a href="?mode=repository::history&action=add&repository_id={$etc_data.repository_id}" class="btn btn-success"><i class="icon-plus icon-white"></i> パッチ履歴新規登録</a></p>
