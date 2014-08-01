  <table class="table table-bordered table-striped">
    <thead>
      <tr style="background-color:#d9edf7;">
        <th>ID</th>
        <th>略称</th>
        <th>運営会社名</th>
        <th>備考</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {foreach from=$data item=row}
      <tr>
        <td>{$row.id}</td>
        <td>{$row.code}</td>
        <td>{$row.name}</td>
        <td>{$row.memo}</td>
        <td><a href="?mode=repository::company&action=edit&id={$row.id}" class="btn"><i class="icon-pencil"></i> 編集</a></td>
        <td><a href="?mode=repository::company&action=delete&id={$row.id}" class="btn btn-danger"><i class="icon-remove"></i> 削除</a></td>
      </tr>
      {/foreach}
    </tbody>
  </table>
