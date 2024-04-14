<template>

    <a-row>
        <a-col :span="20" :offset="2">
            <a-form
                :model="formState"
                :label-col="{ span: 1}"
                :wrapper-col="{ span: 24 }"
                autocomplete="off"
                @finish="onFinish"
            >
                <a-form-item
                    label="Email"
                    name="email"
                >
                    <a-input v-model:value="formState.email"/>
                </a-form-item>

                <a-form-item
                    label="Пароль"
                    name="password"
                >
                    <a-input-password v-model:value="formState.password"/>
                </a-form-item>

                <a-form-item :wrapper-col="{ offset: 23, span: 1 }">
                    <a-button type="primary" html-type="submit">Войти</a-button>
                </a-form-item>
            </a-form>

        </a-col>
    </a-row>


</template>
<script setup>

import {reactive} from 'vue';
import router from "../../routes.js";
import axios from "../../axios.js";

const token = localStorage.getItem("token") ?? ""
if (token.length > 0) {
    router.push({
        name: "users"
    })
}
const formState = reactive({
    email: '',
    password: '',
});

const onFinish = (values) => {
    axios.post("login", {
        email: formState.email,
        password: formState.password,
    }).then((response) => {
        localStorage.setItem("token", response.data.data.token)
        router.push({
            name: "users"
        })
    })
};
</script>
