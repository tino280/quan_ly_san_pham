<template>
  <div class="filter">
    <ul class="filter-list">
      <li class="filter-item">
        <span>Danh mục</span>
      </li>
      <li
        class="filter-item"
        :class="[{ 'filter-item--active': !this.$route.query.type_id }]"
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
            'filter-item--active': parseInt(this.$route.query.type_id) === type.id,
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
        </button>
      </li>
      <li
        class="filter-item"
        :class="[{ 'filter-item--active': !this.$route.query.producer_id }]"
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
              'filter-item--active':
                parseInt(this.$route.query.producer_id) === producer.id,
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
    producers: {
      id: "",
      name: "",
    },
    ok: "",
    checkAdmin: "",
  },
};
</script>
