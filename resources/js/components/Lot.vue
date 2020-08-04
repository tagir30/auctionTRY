<template>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <img class="card-img-top"
                 data-holder-rendered="true"
                 :src="pathImage"
                 style="height: 225px; width: 100%; display: block;">
            <div class="card-body">
                <p class="card-text">
                <h1>{{name}}</h1>
                <h2>{{description}}</h2>
                <h3>{{bet_on_lot}} рублей</h3>
                <h3>{{timeLeft}} часов</h3>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['offer_id', 'name', 'description', 'bet_on_lot', 'timeLeft', 'pathImage'],
        data() {
            return {
            }

        }
    }
</script>
