<div class="modal fade" id="supplier_mail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-dialog-scrollable" action="{{ route('email.inquiry') }}" method="POST">
        @csrf
        <input type="hidden" name="inquiry_id" value="0">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Mail to Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">
                                <input type="checkbox" class="form-check-input">
                            </th>
                            <th width="95%">Supplier</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send Mail</button>
            </div>
        </div>
    </form>
</div>

@push('script')
    <script>
        $("#supplier_mail_modal thead input").click(function() {
            if ($(this).is(":checked")) {
                $("#supplier_mail_modal tbody input").prop("checked", true);
            } else {
                $("#supplier_mail_modal tbody input").prop("checked", false);
            }
        });
    </script>
@endpush
