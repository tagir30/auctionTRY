<template>
        <tr>
            <td>
                <a :href = "showOffer">
                    <img data-holder-rendered="true"
                         :src="pathImage"
                         style="height: 90px; width: 90px; display: block;">
                </a>
            </td>
            <td>{{name}}</td>
            <td>{{description}}</td>
            <td>{{bet_on_lot}} рублей</td>
            <td>{{timeLeft}}</td>
            <a :href = "showOffer"><button class="btn btn-primary">Посмотреть поближе</button></a>

        </tr>
</template>

<script>
    export default {
        props: ['offer_id', 'name', 'description', 'bet_on_lot', 'timeLeft', 'pathImage', 'created_at'],
        data() {
            return {
                showOffer: `/offers/${this.offer_id}`,
            }

        },

    }
</script>
