  <table class="table table-bordered table-striped">
    <thead>
      <tr style="background-color:#d9edf7;">
        <th>格納場所</th>
        <th>コンテンツ</th>
        <th>運営会社</th>
        <th>種別</th>
        <th>リポジトリ名</th>
        <th>備考</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {foreach from=$data item=row}
      <tr>
        <td>{$row.repository_storage_id}</td>
        <td>{$row.repository_contents_id}</td>
        <td>{$row.repository_company_id}</td>
        <td>{$row.repository_type_id}</td>
        <td>{$row.name}</td>
        <td>{$row.memo}</td>
        <td style="position: relative;">{if $row.repository_storage_id == 'staging'}<a href="?mode=repository::history&action=list&repository_id={$row.id}" class="btn btn-inverse"><i class="icon-comment icon-white"></i> パッチ履歴</a>{if $row.history_count != 0}<span class="badge badge-warning" style="position:absolute;top: 2px; left: 90px;">{$row.history_count}</span>{/if}{else}&nbsp;{/if}</td>
        <td><a href="?mode=repository&action=permission&id={$row.id}" class="btn btn-info"><i class="icon-refresh icon-white"></i> 権限</a></td>
        <td><a href="?mode=repository&action=edit&id={$row.id}" class="btn"><i class="icon-pencil"></i> 編集</a></td>
        <td><a href="?mode=repository&action=delete&id={$row.id}" class="btn btn-danger"><i class="icon-remove icon-white"></i> 削除</a></td>
      </tr>
      {/foreach}
    </tbody>
  </table>
