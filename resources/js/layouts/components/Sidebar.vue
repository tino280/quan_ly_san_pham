<template>
  <div class="filter">
    <ul class="filter-list">
      <li class="filter-item">
        <span>Danh mục</span>
      </li>
      <li
        class="filter-item"
        :class="[{ 'filter-item--active': !this.$route.query.type_id && !type_product }]"
      >
        <router-link
          class="filter-link"
          :to="
            checkAdmin
              ? {
                  path: '/admin',
                  query: { producer_id: $route.query.producer_id, q: $route.query.q },
                }
              : {
                  path: '/',
                  query: { producer_id: $route.query.producer_id, q: $route.query.q },
                }
          "
          @change="getProducer('')"
        >
          Tất cả
        </router-link>
      </li>

      <li
        v-for="type in types"
        :key="type.id"
        class="filter-item"
        :class="[
          {
            'filter-item--active': typeActive(type.id, type_product),
          },
        ]"
      >
        <router-link
          class="filter-link"
          :to="
            checkAdmin
              ? {
                  path: '/admin',
                  query: {
                    type_id: type.id,
                    producer_id: $route.query.producer_id,
                    q: $route.query.q,
                  },
                }
              : {
                  path: '/',
                  query: {
                    type_id: type.id,
                    producer_id: $route.query.producer_id,
                    q: $route.query.q,
                  },
                }
          "
          @click="getProducer(type.id)"
        >
          {{ type.name }}
        </router-link>
      </li>
    </ul>
  </div>
  <div class="filter">
    <ul class="filter-list">
      <li class="filter-item">
        <button class="btn-dropdown" type="button" id="dropdown" @click="ok = !ok">
          Hãng sản xuất
          <img style="margin-left: 10px" :src="`${host}/image/Rectangle_195.svg`" />
        </button>
      </li>
      <li
        class="filter-item"
        :class="[
          { 'filter-item--active': !this.$route.query.producer_id && !producer_product },
        ]"
      >
        <router-link
          class="filter-link"
          :to="
            checkAdmin
              ? {
                  path: '/admin',
                  query: { type_id: $route.query.type_id, q: $route.query.q },
                }
              : {
                  path: '/',
                  query: { type_id: $route.query.type_id, q: $route.query.q },
                }
          "
        >
          Tất cả
        </router-link>
      </li>
      <div v-if="ok">
        <li
          v-for="producer in producers"
          :key="producer.id"
          class="filter-item"
          :class="[
            {
              'filter-item--active': producerActive(producer.id, producer_product),
            },
          ]"
        >
          <router-link
            class="filter-link"
            :to="
              checkAdmin
                ? {
                    path: '/admin',
                    query: {
                      type_id: $route.query.type_id,
                      producer_id: producer.id,
                      q: $route.query.q,
                    },
                  }
                : {
                    path: '/',
                    query: {
                      type_id: $route.query.type_id,
                      producer_id: producer.id,
                      q: $route.query.q,
                    },
                  }
            "
            >{{ producer.name }}
          </router-link>
        </li>
      </div>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    types: {
      id: "",
      name: "",
    },
    ok: "",
    checkAdmin: "",
    type_product: "",
    producer_product: "",
  },

  data() {
    return {
      host: window.location.origin,
      producers: "",
    };
  },

  methods: {
    getProducer(type_id) {
      if (type_id) {
        axios.get(`/api/producers/types/${type_id}`).then((response) => {
          this.producers = response.data.data;
        });
      } else {
        axios.get(`/api/producers`).then((response) => {
          this.producers = response.data.data;
        });
      }
    },
    typeActive(type_id, type_product) {
      if (type_id === parseInt(this.$route.query.type_id) || type_id === type_product) {
        return true;
      }
    },
    producerActive(producer_id, producer_product) {
      if (
        producer_id === parseInt(this.$route.query.producer_id) ||
        producer_id === producer_product
      ) {
        return true;
      }
    },
  },

  mounted() {
    this.getProducer("");
  },
};
</script>
