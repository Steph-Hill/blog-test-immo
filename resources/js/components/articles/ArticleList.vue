<template>
    
    <router-link v-bind:to="{name: 'article.create'}"><button type="button">Creer</button></router-link>
    <br>
    <template v-for="article in articles" :key="article.id">
        <span>{{ article.title }}</span>
        <br>
        <br>
        <button v-on:click="deleteArticle(article.id)">
            Delete
        </button>
       
        <router-link v-bind:to="{ name: 'article.edit', params: {id:article.id} }"><button type="button">Edit</button></router-link>
        <br>
        <br>
    </template>
</template>

<script setup>
import useArticles from '../../composables/articles.js';
import { onMounted } from 'vue';

const {articles, getArticles, destroyArticle} = useArticles()

const deleteArticle = async (id) => {
    if(!window.confirm('vous confirmez?')){
        return
    }

    await destroyArticle(id)
    await getArticles()
}

onMounted(getArticles)

</script>