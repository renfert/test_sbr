<template>

  <el-card class="box-card">

    <div slot="header" class="clearfix">
      <el-row>
        <el-button type="danger" round @click="showHtmlEditor"> Html
        </el-button>
        <el-button type="warning" round @click="showJsEditor">
          Javascript
        </el-button>
        <el-button type="primary" round @click="showCssEditor">
          Css
        </el-button>
        <el-button type="success" round @click="showPreviewMode">Result</el-button>
      </el-row>
    </div>
    <div
      v-if="htmlMode">
      <el-row>
        Html:
      </el-row>
      <el-row>

        <MonacoEditor
          width="100%"
          height="400"
          language="html"
          :code="htmlCode"
          :editorOptions="options"
          theme="vs"
          :key="keyxtra"
          @codeChange="htmlCodeChange"
        >
        </MonacoEditor>

      </el-row>
    </div>
    <div
      v-if="javascriptMode">
      <el-row>
        Javascript:
      </el-row>
      <el-row>
        <MonacoEditor
          width="100%"
          height="400"
          language="typescript"
          :code="javascriptCode"
          :editorOptions="options"
          theme="vs"
          :key="keyxtra+1"
          @codeChange="javascriptCodeChange"
        >
        </MonacoEditor>
      </el-row>
    </div>
    <div
      v-if="cssMode">
      <el-row>
        Css:
      </el-row>
      <el-row>
        <MonacoEditor
          width="100%"
          height="400"
          language="css"
          :code="cssCode"
          :editorOptions="options"
          theme="vs"
          :key="keyxtra+2"
          @codeChange="cssCodeChange"
        >
        </MonacoEditor>
      </el-row>
    </div>

    <iframe
      v-if="previewMode"
      id="htmlPreview"
      style="width: 100%; height: 500px;border-width: 0;"
      :key="keyxtra+3"
    >
    </iframe>

  </el-card>
</template>

<script>

import MonacoEditor from 'vue-monaco-editor';

export default {
  components: {
    MonacoEditor
  },
  props: ['javascriptCode', 'htmlCode', 'cssCode'],
  data: () => {
    return {
      keyxtra: 1,
      previewImg: '',
      realName: '',

      options: {
        selectOnLineNumbers: false
      },
      htmlMode: true,
      javascriptMode: false,
      cssMode: false,
      previewMode: false

    };
  },
  methods: {
    htmlCodeChange(editor) {
      this.htmlCode = editor.getValue();
      this.$emit('htmlCode', editor.getValue());
    },
    javascriptCodeChange(editor) {
      this.javascriptCode = editor.getValue();
      this.$emit('javascriptCode', editor.getValue());
    },
    cssCodeChange(editor) {
      this.cssCode = editor.getValue();
      this.$emit('cssCode', editor.getValue());
    },
    showHtmlEditor() {
      this.javascriptMode = false;
      this.cssMode = false;
      this.htmlMode = true;
      this.previewMode = false;
      this.$el.key++;
    },
    showJsEditor() {
      this.htmlMode = false;
      this.cssMode = false;
      this.javascriptMode = true;
      this.previewMode = false;
      this.$el.key++;
    },
    showCssEditor() {
      this.javascriptMode = false;
      this.htmlMode = false;
      this.cssMode = true;
      this.previewMode = false;
      this.$el.key++;
    },
    showPreviewMode() {
      this.javascriptMode = false;
      this.htmlMode = false;
      this.cssMode = false;
      this.previewMode = true;
      this.$el.key++;
      setTimeout(() => {
        const myHtml = this.htmlCode;
        const myScript = '<script>' + this.javascriptCode + '<' + '/script>';
        const myCss = '<style>' + this.cssCode + '</style>';
        const x = document.getElementById('htmlPreview');
        const y = x.contentWindow.document;
        y.open();
        y.writeln(
          myHtml +
          myScript +
          myCss
        );
        y.close();
      }, 700);
    }
  }
};
</script>
