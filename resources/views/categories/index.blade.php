<!-- categories/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>শীর্ষ সংবাদ</h2>
        <table id="sortable" class="table">
            <tbody>
                @foreach ($categories as $category)
                    <tr data-id="{{ $category->id }}" data-serial="{{ $category->serial }}">
                        <td class="handle">&#9776;</td> <!-- Add this handle for dragging -->
                        <td>{{ $category->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#sortable tbody").sortable({
                handle: ".handle", // Set the handle to the handle element
                update: function (event, ui) {
                    var order = $(this).sortable('toArray', { attribute: 'data-id' });
                    updateSortOrder(order);
                }
            }).disableSelection();

            function updateSortOrder(order) {
                order.forEach(function (categoryId, index) {
                    var tr = $("tr[data-id='" + categoryId + "']");
                    var serial = index + 1;
                    tr.find("[data-serial]").text(serial);
                    tr.data("serial", serial);

                    // Send AJAX request to update serial in the database
                    $.ajax({
                        url: '/categories/update-serial',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: categoryId,
                            serial: serial
                        },
                        success: function (response) {
                            console.log(response);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            }
        });
    </script>
@endsection
