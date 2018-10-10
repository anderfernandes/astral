<template>
  <el-menu
    class="el-menu-demo"
    mode="horizontal"
    text-color="#000">
    <el-menu-item>
      <i class="el-icon-menu" style="color:#000 !important"></i>
    </el-menu-item>
    <el-menu-item>
      <img src="/astral-logo-dark.png" style="width:35px; height:35px" />
      <strong>Astral</strong>
    </el-menu-item>
    <el-menu-item>
      Anderson
    </el-menu-item>
  </el-menu>
</template>

<script>
export default {
  data() {
    return {
      activeIndex: '',
      activeIndex2: ''
    };
  },
  methods: {
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    }
  }
}
</script>
