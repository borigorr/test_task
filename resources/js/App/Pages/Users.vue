<template>
    <a-table :dataSource="state.dataSource" :columns="columns" :pagination="state.pagination"
             @change="handleTableChange">
        <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'action'">
                <span>
                    <div>
                        <a @click="deleteUser(record.id)">Удалить</a>
                    </div>
                    <div>
                        <router-link :to="{
                            name: 'edit',
                            params: {
                                'id': record.id
                            }
                        }">Изменить</router-link>
                    </div>
                </span>
            </template>
        </template>

    </a-table>
</template>
<script setup>
import {reactive} from "vue";
import axios from "../../axios.js";

const state = reactive({
    dataSource: [],
    pagination: {
        current: 1,
        total: 1,
        pageSize: 1
    }
})

const columns = [
    {
        title: 'id',
        dataIndex: "id"
    },
    {
        title: 'Email',
        dataIndex: "email"
    },
    {
        title: 'Имя',
        dataIndex: "name"
    },
    {
        title: 'Действия',
        key: 'action',
    },
]

const updateData = (page) => {
    axios.get(`users/?page=${page}`)
        .then((response) => {
            state.dataSource = response.data.data.map((item) => {
                return {
                    key: item.id.toString(),
                    email: item.email,
                    name: item.name,
                    id: item.id
                }
            })
            state.pagination.total = response.data.meta.total
            state.pagination.pageSize = response.data.meta.per_page
            state.pagination.current = page

        })
}

const deleteUser = (id) => {
    axios.delete(`users/${id}`).then(() => {
        updateData(state.pagination.current)
    })
}

const handleTableChange = (
    paginate,
    filters,
    sorter,
) => {
    updateData(paginate.current)
}

updateData(1)

</script>
