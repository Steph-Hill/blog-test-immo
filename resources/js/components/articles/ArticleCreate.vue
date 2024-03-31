<template>
    <h1>Créer son article</h1>
    <div v-if="errors">
        <div v-for="(v,k) in errors" :key="k">
            <p v-for="error in v" :key="error">
                {{ error }}
            </p>

        </div>
    </div>

    <form action="" @submit.prevent="addArticle" enctype="multipart/form-data">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" v-model="form.title">
        <br>
        <br>
        <label for="content">Description</label>
        <textarea name="content" id="content" v-model="form.content"></textarea>
        <br>
        <br>
        <label for="image">Image</label>
        <input type="file" @change="getImage" :required="false">
        
        <button type="submit">Créer</button>
    </form>

</template>

<script setup>
import useArticles from '../../composables/articles';
import {reactive} from 'vue'

const form = reactive({
    title:'',
    content:'',
    image: null,
})
console.log('form :',form)

const getImage = (event) => {
    form.image = event.target.files[0];
    console.log('event :',event)
    console.log('mon img : ',form.image);
};
console.log('getImage',getImage)
const {errors, storeArticle} = useArticles()


const addArticle = async () => {
    const formData = new FormData();

    formData.append('title', form.title);
    console.log('formdata title :',form.title)

    formData.append('content', form.content);
    console.log('formdata title :',form.content)

    if(form.image) {
        console.log('image Article :',form.image)

        formData.append('image', form.image);
        console.log('formdata image',form.image)
    }

    await storeArticle(formData);
    console.log('storeArticle',storeArticle)
}

</script> 