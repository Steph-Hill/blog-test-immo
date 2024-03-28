import {createRouter, createWebHistory } from 'vue-router'

import ArticleList from '../components/articles/ArticleList.vue'
import ArticleCreate from '../components/articles/ArticleCreate.vue'
import ArticleEdit from '../components/articles/ArticleEdit.vue'

const routes = [
    {
        path:'/mes-articles',
        name:'article.list',
        component: ArticleList
    },
    {
        path:'/article/create',
        name:'article.create',
        component: ArticleCreate
    },
    {
        path:'/article/:id/edit',
        name:'article.edit',
        component: ArticleEdit,
        props: true
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})