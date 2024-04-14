<template>
    <a-row>
        <a-col :offset="2" :span="20">
            <a-form
                :model="state"
                autocomplete="off"
                :label-col="{ span: 2}"
                :wrapper-col="{ span: 18 }"
                @finish="onFinish"
            >
                <a-form-item label="Имя" name="name">
                    <a-input v-model:value="state.name" />
                </a-form-item>
                <a-form-item label="Email" name="email">
                    <a-input v-model:value="state.email" />
                </a-form-item>
                <a-form-item :wrapper-col="{ span: 2, offset: 10 }">
                    <a-button type="primary"  html-type="submit">Сохранить</a-button>
                </a-form-item>
            </a-form>
        </a-col>
    </a-row>
</template>
<script setup>
import {reactive} from "vue";
import axios from "../../axios.js";
import { useRoute } from 'vue-router'

const state = reactive({
    name: "",
    email: ""
})
const route = useRoute()
const userId = route.params.id


const getUserData = () => {
    axios.get(`users/${userId}`).then((response) => {
        const data = response.data.data
        state.email = data.email
        state.name = data.name
    })
}

const onFinish = () => {
    axios.put(`users/${userId}`, {
        name:  state.name,
        email:  state.email
    }).then((response) => {
        getUserData()
        alert("Пользователь созранен")
    })
}
getUserData()
</script>
