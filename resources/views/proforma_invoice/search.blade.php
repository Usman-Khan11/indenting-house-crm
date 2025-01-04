<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Country Name</th>
            <th>Product</th>
            <th>Size Name</th>
            <th>Card No</th>
            <th>CUS ID</th>
            <th>Size ID</th>
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $value)
            <tr>
                <td>{{ $value->location }}</td>
                <td>{{ $value->product }}</td>
                <td>{{ $value->size_name }}</td>
                <td>{{ $value->card_no }}</td>
                <td>{{ $value->customer_id }}</td>
                <td>{{ $value->size_id }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-xs"
                        onclick="search_selection(this, '{{ $value->card_id }}')">Select</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
