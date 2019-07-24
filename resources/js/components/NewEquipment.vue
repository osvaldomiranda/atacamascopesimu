<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="800"
    >
      <template v-slot:activator="{ on }">
        <v-btn
          color="success"
          dark
          v-on="on"
        >
        	Nuevo Equipamiento  
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          Nuevo Equipamiento
        </v-card-title>

        <v-card-text>
 
        	<v-container grid-list-md>
            	<v-layout wrap>
              		<v-flex xs12>
                		<v-text-field label="Nombre Equipo" required></v-text-field>
              		</v-flex>
              		<v-flex xs12>
              			<editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
					      <div class="menubar">

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.bold() }"
					          @click="commands.bold"
					        >
					          <v-icon>format_bold</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.italic() }"
					          @click="commands.italic"
					        >
					          <v-icon>format_italic</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.strike() }"
					          @click="commands.strike"
					        >
					          <v-icon>format_strikethrough</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.underline() }"
					          @click="commands.underline"
					        >
					          <v-icon>format_underlined</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.code() }"
					          @click="commands.code"
					        >
					          <v-icon>code</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.heading({ level: 1 }) }"
					          @click="commands.heading({ level: 1 })"
					        >
					          H1
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.heading({ level: 2 }) }"
					          @click="commands.heading({ level: 2 })"
					        >
					          H2
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.heading({ level: 3 }) }"
					          @click="commands.heading({ level: 3 })"
					        >
					          H3
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.bullet_list() }"
					          @click="commands.bullet_list"
					        >
					          <v-icon>format_list_bulleted</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.ordered_list() }"
					          @click="commands.ordered_list"
					        >
					          <v-icon>format_list_numbered</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          :class="{ 'is-active': isActive.blockquote() }"
					          @click="commands.blockquote"
					        >
					          <v-icon>format_quote</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          @click="commands.undo"
					        >
					          <v-icon>undo</v-icon>
					        </button>

					        <button
					          class="menubar__button"
					          @click="commands.redo"
					        >
					          <v-icon>redo</v-icon>
					        </button>

					      </div>
					    </editor-menu-bar>

			        	<editor-content :editor="editor" />
              		</v-flex>	

			 	</v-layout>
			</v-container>
            	

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
            @click="dialog = false"
          >
            Guardar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>





<script>
// Import the basic building blocks

import { Editor, EditorContent, EditorMenuBar } from 'tiptap'
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
} from 'tiptap-extensions'

export default {
  components: {
    EditorContent,
    EditorMenuBar,
  },
  data() {
    return {
      dialog: false,	
      // Create an `Editor` instance with some default content. The editor is 
      // then passed to the `EditorContent` component as a `prop`
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new BulletList(),
          new OrderedList(),
          new ListItem(),
          new TodoItem(),
          new TodoList(),
          new Bold(),
          new Code(),
          new Italic(),
          new Link(),
          new Strike(),
          new Underline(),
          new History(),
        ],
        content: `
          <h3>Descripción</h1>
          
        `,
      }),
    }
  },
  beforeDestroy() {
    // Always destroy your editor instance when it's no longer needed
    this.editor.destroy()
  },
}
</script>