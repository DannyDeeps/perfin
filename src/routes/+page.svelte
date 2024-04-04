<script>
  /** @type {import("./$types").PageData} */
  export let data;
</script>

<main class="container-fluid">
  <div class="row gap-3">
    <div class="col-12">
      <div class="h3">Data Ingest</div>

      <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="upload" id="upload" accept="text/csv" />
        <button type="submit">Upload</button>
      </form>
    </div>

    <div class="col-12">
      <table class="table table-sm caption-top">
        <caption class="h2">All Transactions</caption>
        <thead>
          <tr class="table-dark">
            <th>date</th>
            <th>description</th>
            <th>in</th>
            <th>out</th>
            <th>balance</th>
          </tr>
        </thead>

        <tbody>
          {#each data.transactions as transaction}
            <tr>
              <td>{transaction.date}</td>
              <td>{transaction.description}</td>
              <td>&pound;{transaction.credit_amount}</td>
              <td>&pound;{transaction.debit_amount}</td>
              <td>&pound;{transaction.balance}</td>
            </tr>
          {/each}
        </tbody>

        <tfoot>
          <tr class="table-dark">
            <td colspan="2">Totals</td>
            <td>&pound;{data.totals.credit_amount}</td>
            <td>&pound;{data.totals.debit_amount}</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</main>
