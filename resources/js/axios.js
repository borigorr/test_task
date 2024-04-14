/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import router from "./routes.js";


let http = axios.create({
    baseURL: `${import.meta.env.VITE_APP_URL}api/`,
});


http.interceptors.response.use(
    (response) => response,
    (error) => {
        const statusCode = error.response.status;
        if (statusCode === 401) {
            localStorage.setItem("token", "")
            router.push({
                name: "login"
            })
        }
        if (statusCode === 422) {
            alert(error.response.data.message)
        }
        return Promise.reject(error);
    },
)

http.interceptors.request.use(
    (request) => {

        request.headers.set("accept", "application/json")
        request.headers.set("Content-Type", "application/json")
        const token = localStorage.getItem("token") ?? ""
        if (token.length > 0) {
            request.headers.set("Authorization", `Bearer ${token}`)
        }
        return request
    },
    (error) => error
)

export default http
