<template>
    <h1>modifier l'article</h1>
    <div v-if="errors">
        <div v-for="(v,k) in errors" :key="k">
            <p v-for="error in v" :key="error">
               ok {{ error }}
            </p>

        </div>
    </div>

    <form v-on:submit.prevent="saveArticle" enctype="multipart/form-data" >
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" v-model="article.title">
        <br>
        <br>
        <label for="content">Description</label>
        <textarea name="content" id="content" cols="30" rows="10" v-model="article.content" ></textarea>
        <br>
        <br>
               
        <button type="submit">Save</button>
    </form>
</template>

<script setup>
import useArticles from '../../composables/articles';
import {onMounted} from 'vue';

const { errors, article, updateArticle, getArticle } = useArticles()

const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

onMounted(() => getArticle(props.id))


const saveArticle = async () => {
       
    await updateArticle(props.id)
}
console.log(saveArticle())
</script>