import axios, { AxiosRequestConfig, AxiosResponse } from 'axios';

const instance = axios.create();

instance.interceptors.request.use(function (request: AxiosRequestConfig): AxiosRequestConfig | Promise<AxiosRequestConfig> {
    if (request.method === 'patch' || request.method === 'put') {
        request.headers = {
            ...request.headers,
            accept: 'application/json'
        };
    }

    return request;
});

instance.interceptors.response.use(function (response: AxiosResponse): AxiosResponse<unknown> | Promise<AxiosResponse<unknown>> {
    return response;
}, function (error) {
    if (error.response.status === 401) {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }

    return Promise.reject(error);
});

export default instance;