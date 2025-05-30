@extends('layouts.app')

@section('title')
Live Kitchen
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <a href="#" onclick="refreshList()" class="btn btn-default waves-effect">Refresh</a>
        </div>

        <h4 class="page-title">Live Kitchen</h4>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Live Kitchen</li>
        </ol>
    </div>
</div>

<div class="row" id="renderHtmlHere"></div>
@endsection

@section('extra-js')
<style>
    .dish-details {
        height: 200px;
        overflow-y: scroll;
    }
</style>

<script>
    let orders = [];

        function refreshList() {
            $.get('/live-kitchen-admin-json', function (data) {
                orders = data;
                renderHTML(orders);
            });
        }

        function    serve(index) {
            if (confirm('Are you sure?')) {
                $.get('/order-served/' + orders[index].id, function () {
                    orders.splice(index, 1);
                    renderHTML(orders);
                });
            }
        }

        function renderHTML(data) {
            const $container = $("#renderHtmlHere");
            $container.empty();

            data.forEach((dish, index) => {
                const panelColor = dish.status == 0 ? "panel-warning" : "panel-custom";
                const $card = $("<div>", { class: "col-lg-4" }).append(
                    $("<div>", { class: `panel panel-color ${panelColor}` }).append(
                        $("<div>", { class: "panel-heading" }).append(
                            $("<h3>", { class: "panel-title" }).text(
                                dish.kitchen ? dish.kitchen.name : "Kitchen did not respond yet"
                            ).append(
                                $("<span>", {
                                    class: "pull-right",
                                    text: dish.served_by?.name ?? ''
                                })
                            )
                        ),
                        $("<div>", { class: "panel-body dish-details" }).append(
                            $("<ul>", { class: "list-group" }).append(
                                dish.order_details.map(detail =>
                                    $("<li>", { class: "list-group-item" }).text(detail.dish.dish).append(
                                        $("<span>", {
                                            class: "badge badge-success",
                                            text: detail.dish_type.dish_type
                                        })
                                    )
                                )
                            )
                        ),
                        createStatusButton(dish.status, index)
                    )
                );
                $container.append($card);
            });
        }

        function createStatusButton(status, index) {
            const baseClass = "btn btn-block btn-lg btn-primary waves-effect waves-light";
            if (status === 0) {
                return $("<button>", { class: baseClass, text: "Pending for kitchen response", disabled: true });
            } else if (status === 1) {
                return $("<button>", { class: baseClass, text: "Cooking", disabled: true });
            } else if (status === 2) {
                return $("<button>", {
                    class: baseClass,
                    text: "Complete! Waiting for serve",
                    click: () => serve(index)
                });
            } else {
                return $("<div>").text("Oops");
            }
        }

        $(document).ready(function () {
            // Initial load
            refreshList();

            // Pusher subscriptions
            const eventChannels = [
                { channel: 'order', event: 'order-event' },
                { channel: 'start-cooking', event: 'kitchen-event' },
                { channel: 'complete-cooking', event: 'complete-cooking-event' },
                { channel: 'order-served', event: 'order-served-event' },
                { channel: 'cancel-order', event: 'order-cancel-event' },
                { channel: 'update-order', event: 'order-update-event' },
            ];

            eventChannels.forEach(({ channel, event }) => {
                const ch = pusher.subscribe(channel);
                ch.bind(event, () => refreshList());
            });
        });
</script>
@endsection
