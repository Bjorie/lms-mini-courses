import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

window.initTiptap = (
    element,
    content = '',
    onChange = null
) => {

    let timeout = null;

    return new Editor({

        element,

        extensions: [
            StarterKit,
        ],

        content,

        onUpdate({ editor }) {

            clearTimeout(timeout);

            timeout = setTimeout(() => {

                if (onChange) {
                    onChange(
                        editor.getHTML()
                    );
                }

            }, 300);

        },

    });

};