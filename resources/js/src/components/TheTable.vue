<script>
export default {
    data() {
        return {
            wallets: []
        }
    },
    async mounted() {
        try {
            // const { data } = await this.$axios.get("/api/fetchWalletsOfUser")

            this.wallets = data
        } catch (error) {
            console.log(error)
        }
    }
}
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Para birimi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tutar
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        Son güncelleme
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(Wallet, index) in wallets" :key="index" class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        {{ Wallet.currency }}
                    </th>
                    <td class="px-6 py-4">
                        {{ Wallet.totalAmount }}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                        {{ $dayjs(Wallet.updated_at) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>