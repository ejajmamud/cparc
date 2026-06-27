(() => {
  // console.log('>> Site Assets index.js LOADED <<');
  // TABS system
  let tabGroups = document.querySelectorAll('.container-tabs');
  tabGroups.forEach((g) => {
    let groupHead = document.createElement('div');
    let groupBody = document.createElement('div');
    groupHead.classList.add('container-tab-head-group');
    groupHead.setAttribute('data-tab-head', 'tab-head-group');
    groupBody.classList.add('container-tab-body-group');
    // let tabs = g.querySelectorAll('.container-tab');
    let tabs = [...g.children];
    let removeBtn = null;
    tabs.forEach((t) => {
      let head = t.children[0]?.classList?.contains('container-tab-head')
        ? t.children[0]
        : null;
      let body = t.children[1]?.classList?.contains('container-tab-body')
        ? t.children[1]
        : null;
      if (head && body) {
        groupHead.appendChild(head);
        groupBody.appendChild(body);
        head.setAttribute('title', head.innerText.trim());
        body.setAttribute('data-title', head.innerText.trim());
        head.addEventListener('click', () => {
          [...head.parentElement.children].forEach((c) =>
            c.classList.remove('active'),
          );
          [...body.parentElement.children].forEach((c) =>
            c.classList.remove('active'),
          );
          head.classList.add('active');
          body.classList.add('active');
        });
      }
      if (t.classList?.contains('page-widget-delete-button')) {
        removeBtn = t;
      }
      t.remove();
    });
    g.appendChild(groupHead);
    g.appendChild(groupBody);
    if (removeBtn) g.appendChild(removeBtn);
    groupHead.children[0]?.classList.add('active');
    groupBody.children[0]?.classList.add('active');
  });

  // Rich Text Renderer
  const tinymceStyles = `
    /*@import url('https://fonts.googleapis.com/css2?family=Cabin&family=Dosis&family=Nunito&family=Raleway&family=Urbanist&display=swap');
    @font-face {
      font-family: 'Hikou';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: url(/fonts/Hikou_Regular.otf) format('opentype');
    }
    body { font-family: Arial; }*/
    table { max-width: 100%; block-size: auto; border-collapse: collapse; }
    img { max-width: 100%; block-size: auto; }
    iframe { max-width: 100%; border: none; }
    
    /******* base.css ********/
    .ulli li{
      list-style:inside none circle;
    }

    /* #Typography
    ================================================== */
    h1, h2, h3, h4, h5, h6 {
      color: #181818;
      /*font-family: "Georgia", "Times New Roman", serif;*/
      font-weight: normal;
    }
    h3, h4, h5, h6 {
      margin: 0;
    }
    h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { font-weight: inherit; }
    h1 { font-size: 46px; line-height: 50px; margin-bottom: 14px;}
    h2 { font-size: 35px; line-height: 40px; margin-bottom: 10px; }
    h3 {font-size: 28px;line-height: 34px;margin-bottom: 8px;}
    h4 { font-size: 21px; line-height: 30px; margin-bottom: 4px; }
    h5 { font-size: 17px; line-height: 24px; }
    h6 { font-size: 14px; line-height: 21px; }
    .subheader { color: #777; }
  
    p { margin: 0 0 20px 0; /*width:100%;*/ width:-webkit-fill-available; }
    p img { margin: 0; }
    p.lead { font-size: 21px; line-height: 27px; color: #777;  }
  
    em { font-style: italic; }
    strong { font-weight: bold; /*color: #333;*/ }
    small { font-size: 80%; }
  
    /* Blockquotes  */
    blockquote, blockquote p { font-size: 17px; line-height: 24px; color: #777; font-style: italic; }
    blockquote { margin: 0 0 20px; padding: 9px 20px 0 19px; border-left: 1px solid #ddd; }
    blockquote cite { display: block; font-size: 12px; color: #555; }
    blockquote cite:before { content: "\\2014 \\0020"; }
    blockquote cite a, blockquote cite a:visited, blockquote cite a:visited { color: #555; }
  
    hr { border: solid #ddd; border-width: 1px 0 0; clear: both; margin: 10px 0 30px; height: 0; }

    /* #Links
    ================================================== */
    a, a:visited { color: #333; text-decoration: none; outline: 0; }
    a:hover, a:focus { color: #000; }
    p a, p a:visited { line-height: inherit; }
  
  
    /* #Lists
    ================================================== */
    ul, ol { margin-bottom: 20px; }
    ul { list-style: none; }
    #left-content ul { list-style: disc; }
    /*#left-content ul li{ margin-left: 20px }*/
  
    ol { list-style: decimal; }
    ol, ul.square, ul.circle, ul.disc { margin-left: 30px; }
    ul.square { list-style: square outside; }
    ul.circle { list-style: circle outside; }
    ul.disc { list-style: disc outside; }
    /*ul ul, ul ol, ol ol, ol ul { margin: 4px 0 5px 30px; font-size: 90%; }*/
    ul ul li, ul ol li, ol ol li, ol ul li { margin-bottom: 6px; }
    li { line-height: 18px; margin-bottom: 12px; }
    ul.large li { line-height: 21px; }
    li p { line-height: 21px; }
  
    /* #Images
    ================================================== */
    img.scale-with-grid {
      max-width: 100%;
      height: auto;
    }
  `;

  const ckEditorStyles = `
:root{
  --ck-color-mention-background:hsla(341, 100%, 30%, 0.1);
  --ck-color-mention-text:hsl(341, 100%, 30%);
}
.ck-content .mention{
  background:var(--ck-color-mention-background);
  color:var(--ck-color-mention-text);
}

.ck-content code{
  background-color:hsla(0, 0%, 78%, 0.3);
  padding:.15em;
  border-radius:2px;
}

.ck-content blockquote{
  overflow:hidden;
  padding-right:1.5em;
  padding-left:1.5em;

  margin-left:0;
  margin-right:0;
  font-style:italic;
  border-left:solid 5px hsl(0, 0%, 80%);
}

.ck-content[dir="rtl"] blockquote{
  border-left:0;
  border-right:solid 5px hsl(0, 0%, 80%);
}

.ck-content pre{
  padding:1em;
  color:hsl(0, 0%, 20.8%);
  background:hsla(0, 0%, 78%, 0.3);
  border:1px solid hsl(0, 0%, 77%);
  border-radius:2px;
  text-align:left;
  direction:ltr;
  tab-size:4;
  white-space:pre-wrap;
  font-style:normal;
  min-width:200px;
}

.ck-content pre code{
  background:unset;
  padding:0;
  border-radius:0;
}
.ck-content .text-tiny{
  font-size:.7em;
}
.ck-content .text-small{
  font-size:.85em;
}
.ck-content .text-big{
  font-size:1.4em;
}
.ck-content .text-huge{
  font-size:1.8em;
}

:root{
  --ck-highlight-marker-yellow:hsl(60, 97%, 73%);
  --ck-highlight-marker-green:hsl(120, 93%, 68%);
  --ck-highlight-marker-pink:hsl(345, 96%, 73%);
  --ck-highlight-marker-blue:hsl(201, 97%, 72%);
  --ck-highlight-pen-red:hsl(0, 85%, 49%);
  --ck-highlight-pen-green:hsl(112, 100%, 27%);
}

.ck-content .marker-yellow{
  background-color:var(--ck-highlight-marker-yellow);
}
.ck-content .marker-green{
  background-color:var(--ck-highlight-marker-green);
}
.ck-content .marker-pink{
  background-color:var(--ck-highlight-marker-pink);
}
.ck-content .marker-blue{
  background-color:var(--ck-highlight-marker-blue);
}

.ck-content .pen-red{
  color:var(--ck-highlight-pen-red);
  background-color:transparent;
}
.ck-content .pen-green{
  color:var(--ck-highlight-pen-green);
  background-color:transparent;
}

.ck-content hr{
  margin:15px 0;
  height:4px;
  background:hsl(0, 0%, 87%);
  border:0;
}

:root{
  --ck-color-image-caption-background:hsl(0, 0%, 97%);
  --ck-color-image-caption-text:hsl(0, 0%, 20%);
}
.ck-content .image > figcaption{
  display:table-caption;
  caption-side:bottom;
  word-break:break-word;
  color:var(--ck-color-image-caption-text);
  background-color:var(--ck-color-image-caption-background);
  padding:.6em;
  font-size:.75em;
  outline-offset:-1px;
}
@media (forced-colors: active){
  .ck-content .image > figcaption{
    background-color:unset;
    color:unset;
  }
}
.ck-content img.image_resized{
  height:auto;
}

.ck-content .image.image_resized{
  max-width:100%;
  display:block;
  box-sizing:border-box;
}

.ck-content .image.image_resized img{
  width:100%;
}

.ck-content .image.image_resized > figcaption{
  display:block;
}

:root{
  --ck-image-style-spacing:1.5em;
  --ck-inline-image-style-spacing:calc(var(--ck-image-style-spacing) / 2);
}

.ck-content .image.image-style-block-align-left,
.ck-content .image.image-style-block-align-right{
  max-width:calc(100% - var(--ck-image-style-spacing));
}

.ck-content .image.image-style-align-left,
.ck-content .image.image-style-align-right{
  clear:none;
}

.ck-content .image.image-style-side{
  float:right;
  margin-left:var(--ck-image-style-spacing);
  max-width:50%;
}

.ck-content .image.image-style-align-left{
  float:left;
  margin-right:var(--ck-image-style-spacing);
}

.ck-content .image.image-style-align-right{
  float:right;
  margin-left:var(--ck-image-style-spacing);
}

.ck-content .image.image-style-block-align-right{
  margin-right:0;
  margin-left:auto;
}

.ck-content .image.image-style-block-align-left{
  margin-left:0;
  margin-right:auto;
}

.ck-content .image-style-align-center{
  margin-left:auto;
  margin-right:auto;
}

.ck-content .image-style-align-left{
  float:left;
  margin-right:var(--ck-image-style-spacing);
}

.ck-content .image-style-align-right{
  float:right;
  margin-left:var(--ck-image-style-spacing);
}

.ck-content p + .image.image-style-align-left,
.ck-content p + .image.image-style-align-right,
.ck-content p + .image.image-style-side{
  margin-top:0;
}

.ck-content .image-inline.image-style-align-left,
.ck-content .image-inline.image-style-align-right{
  margin-top:var(--ck-inline-image-style-spacing);
  margin-bottom:var(--ck-inline-image-style-spacing);
}

.ck-content .image-inline.image-style-align-left{
  margin-right:var(--ck-inline-image-style-spacing);
}

.ck-content .image-inline.image-style-align-right{
  margin-left:var(--ck-inline-image-style-spacing);
}

.ck-content .image{
  display:table;
  clear:both;
  text-align:center;
  margin:0.9em auto;
  min-width:50px;
}

.ck-content .image img{
  display:block;
  margin:0 auto;
  max-width:100%;
  min-width:100%;
  height:auto;
}

.ck-content .image-inline{
  display:inline-flex;
  max-width:100%;
  align-items:flex-start;
}

.ck-content .image-inline picture{
  display:flex;
}

.ck-content .image-inline picture,
.ck-content .image-inline img{
  flex-grow:1;
  flex-shrink:1;
  max-width:100%;
}

.ck-content ol{
  list-style-type:decimal;
}

.ck-content ol ol{
  list-style-type:lower-latin;
}

.ck-content ol ol ol{
  list-style-type:lower-roman;
}

.ck-content ol ol ol ol{
  list-style-type:upper-latin;
}

.ck-content ol ol ol ol ol{
  list-style-type:upper-roman;
}

.ck-content ul{
  list-style-type:disc;
}

.ck-content ul ul{
  list-style-type:circle;
}

.ck-content ul ul ul{
  list-style-type:square;
}

.ck-content ul ul ul ul{
  list-style-type:square;
}

:root{
  --ck-todo-list-checkmark-size:16px;
}
.ck-content .todo-list{
  list-style:none;
}
.ck-content .todo-list li{
  position:relative;
  margin-bottom:5px;
}
.ck-content .todo-list li .todo-list{
  margin-top:5px;
}
.ck-content .todo-list .todo-list__label > input{
  -webkit-appearance:none;
  display:inline-block;
  position:relative;
  width:var(--ck-todo-list-checkmark-size);
  height:var(--ck-todo-list-checkmark-size);
  vertical-align:middle;
  border:0;
  left:-25px;
  margin-right:-15px;
  right:0;
  margin-left:0;
}
.ck-content[dir=rtl] .todo-list .todo-list__label > input{
  left:0;
  margin-right:0;
  right:-25px;
  margin-left:-15px;
}
.ck-content .todo-list .todo-list__label > input::before{
  display:block;
  position:absolute;
  box-sizing:border-box;
  content:'';
  width:100%;
  height:100%;
  border:1px solid hsl(0, 0%, 20%);
  border-radius:2px;
  transition:250ms ease-in-out box-shadow;
}
@media (prefers-reduced-motion: reduce){
  .ck-content .todo-list .todo-list__label > input::before{
    transition:none;
  }
}
.ck-content .todo-list .todo-list__label > input::after{
  display:block;
  position:absolute;
  box-sizing:content-box;
  pointer-events:none;
  content:'';
  left:calc( var(--ck-todo-list-checkmark-size) / 3);
  top:calc( var(--ck-todo-list-checkmark-size) / 5.3);
  width:calc( var(--ck-todo-list-checkmark-size) / 5.3);
  height:calc( var(--ck-todo-list-checkmark-size) / 2.6);
  border-style:solid;
  border-color:transparent;
  border-width:0 calc( var(--ck-todo-list-checkmark-size) / 8) calc( var(--ck-todo-list-checkmark-size) / 8) 0;
  transform:rotate(45deg);
}
.ck-content .todo-list .todo-list__label > input[checked]::before{
  background:hsl(126, 64%, 41%);
  border-color:hsl(126, 64%, 41%);
}
.ck-content .todo-list .todo-list__label > input[checked]::after{
  border-color:hsl(0, 0%, 100%);
}
.ck-content .todo-list .todo-list__label .todo-list__label__description{
  vertical-align:middle;
}
.ck-content .todo-list .todo-list__label.todo-list__label_without-description input[type=checkbox]{
  position:absolute;
}

.ck-content .media{
  clear:both;
  margin:0.9em 0;
  display:block;
  min-width:15em;
}

.ck-content .page-break{
  position:relative;
  clear:both;
  padding:5px 0;
  display:flex;
  align-items:center;
  justify-content:center;
}

.ck-content .page-break::after{
  content:'';
  position:absolute;
  border-bottom:2px dashed hsl(0, 0%, 77%);
  width:100%;
}

.ck-content .page-break__label{
  position:relative;
  z-index:1;
  padding:.3em .6em;
  display:block;
  text-transform:uppercase;
  border:1px solid hsl(0, 0%, 77%);
  border-radius:2px;
  font-family:Helvetica, Arial, Tahoma, Verdana, Sans-Serif;
  font-size:0.75em;
  font-weight:bold;
  color:hsl(0, 0%, 20%);
  background:hsl(0, 0%, 100%);
  box-shadow:2px 2px 1px hsla(0, 0%, 0%, 0.15);
  -webkit-user-select:none;
  -moz-user-select:none;
  -ms-user-select:none;
  user-select:none;
}
@media print{
  .ck-content .page-break{
    padding:0;
  }
  .ck-content .page-break::after{
    display:none;
  }
  .ck-content *:has(+ .page-break){
    margin-bottom:0;
  }
}

.ck-content .table{
  margin:0.9em auto;
  display:table;
}

.ck-content .table table{
  border-collapse:collapse;
  border-spacing:0;
  width:100%;
  height:100%;
  border:1px double hsl(0, 0%, 70%);
}

.ck-content .table table td,
.ck-content .table table th{
  min-width:2em;
  padding:.4em;
  border:1px solid hsl(0, 0%, 75%);
}

.ck-content .table table th{
  font-weight:bold;
  background:hsla(0, 0%, 0%, 5%);
}
@media print{
  .ck-content .table table{
    height:initial;
  }
}
.ck-content[dir="rtl"] .table th{
  text-align:right;
}

.ck-content[dir="ltr"] .table th{
  text-align:left;
}

:root{
  --ck-color-selector-caption-background:hsl(0, 0%, 97%);
  --ck-color-selector-caption-text:hsl(0, 0%, 20%);
}
.ck-content .table > figcaption{
  display:table-caption;
  caption-side:top;
  word-break:break-word;
  text-align:center;
  color:var(--ck-color-selector-caption-text);
  background-color:var(--ck-color-selector-caption-background);
  padding:.6em;
  font-size:.75em;
  outline-offset:-1px;
}
@media (forced-colors: active){
  .ck-content .table > figcaption{
    background-color:unset;
    color:unset;
  }
}

.ck-content .table .ck-table-resized{
  table-layout:fixed;
}

.ck-content .table table{
  overflow:hidden;
}

.ck-content .table td,
.ck-content .table th{
  overflow-wrap:break-word;
  position:relative;
}
`;

  const shadowDomStyles = `
    .wrapper {
      font-family:var(--font-secondary-en);
      overflow-wrap: anywhere;
      background-color: #fff0;
      overflow: auto;/* clear fix */
      /*overflow: initial;*/
    }
    .wrapper::after {/* clear fix */
      content: "";
      clear: both;
      display: table;
    }
    .wrapper.slim-width {
      overflow: hidden;/* clear fix */
    }
    /*.wrapper.slim-width img:not(table img)*/
    .wrapper.slim-width img:not(table img):not(.title img):first-child:last-child {
      display: block;
      box-sizing: border-box;
      height: auto !important;
      width: 100% !important;
      max-height: 720px;
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
    .wrapper.slim-width .__rt_only_nbsp:first-child { display: none; }
    .wrapper.slim-width .__rt_only_nbsp+.__rt_only_nbsp { display: none; }
    .wrapper ul li {
      height: auto;
      box-sizing: border-box;
    }
    .wrapper.slim-width ul li {
      padding-top: 0px;
      padding-bottom: 8px;
      padding-left: 32px;
      list-style-type: none;
      margin-bottom: 5px;
      background: url("/site-assets/images/right-tick.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
      background-position: 0px 1px;
    }
    .wrapper p {
      margin:0;
      font-size:var(--typography-body-font-size)
    }
    .wrapper.slim-width ul {
      padding:0;/**/
      /*list-style: none;*/
      list-style: circle;
      list-style-position: inside;
    }
    .wrapper a{
      text-decoration:none;
      color:var(--color-normal-text);
    }
    .wrapper a[href], .wrapper a[href]:visited { text-decoration: none; }
    .wrapper a[href$=".pdf"],
    .wrapper a[href$=".jpg"],
    .wrapper a[href$=".jpeg"],
    .wrapper a[href$=".png"],
    .wrapper a[href$=".gif"],
    .wrapper a[href$=".bmp"],
    .wrapper a[href$=".webp"] {
      /*text-decoration: underline;*/
    }
    td {
     box-sizing: border-box !important;
     padding: 5px !important;
     border: 1px solid #aaa !important;
     overflow-wrap: break-word;
    }
    .wrapper iframe{
      box-sizing: border-box;
    }
    .wrapper>marquee{
      margin: 10px 0px;
    }
    table img { max-width: unset; }
  `;

  const modifyOldStyles = `
  .wrapper.slim-width p span strong > a { /* DIRTY FIX FOR: জরুরি হেল্পলাইন নম্বর */ /* UPDATE: slim-width */
    /*text-decoration:underline;*/
    float:right;
  }
  h3.title, h4.title, h5.title, h6.title {
    background-color: var(--color-primary-dark);
    color: var(--color-secondary-text);
    padding: var(--spacing-small);
    font-size: var(--text-medium);
    /*border-radius: var(--radius-small);*/
    font-weight: 600;
    margin: var(--spacing-small) 0;
    display: flex;
    align-items: center
  }
  h3.title img, h4.title img, h5.title img, h6.title img {
    height: 28px;
    width: 28px;
    margin-right: 8px;
  }
  `;

  function urlContentToDataUri(url) {
    return fetch(url)
      .then((response) => response.blob())
      .then(
        (blob) =>
          new Promise((callback) => {
            let reader = new FileReader();
            reader.onload = function () {
              callback(this.result);
            };
            reader.readAsDataURL(blob);
          }),
      );
  }

  const fileBaseUrl = '/';

  class RichTextRenderer extends HTMLElement {
    initialHTML = '';

    constructor() {
      // Always call super first in constructor
      super();
      // console.log('CON >>', this);
      // Element functionality written in here
    }

    connectedCallback() {
      // console.log('Custom tinymce element added to page.', super.innerHTML);
      this.initialHTML = super.innerHTML;
      this.innerText = '';
      this.renderer();
    }

    disconnectedCallback() {
      // console.log('Custom tinymce element removed from page.');
    }

    adoptedCallback() {
      // console.log('Custom tinymce element moved to new page.');
    }

    attributeChangedCallback(name, oldValue, newValue) {
      // console.log('RTRenderer attributes >>', [name, oldValue, newValue]);
      // updateStyle(this);
      function isBase64(str) {
        //TODO this is dirty fix
        try {
          return btoa(atob(str)) === str;
        } catch {
          return false;
        }
      }

      if (name === 'slim-width') {
        this.slimWidth = true;
        this.renderer();
      } else if (name === 'encoded-content' && newValue !== '') {
        this.encodedContent = newValue;
        const chunks = newValue.split(';');
        const newHTML = chunks
          .map((chunk) => {
            if (isBase64(chunk)) {
              return new TextDecoder().decode(
                Uint8Array.from(atob(chunk), (c) => c.charCodeAt(0)),
              );
            } else {
              return chunk; //TODO fix me
            }
          })
          .join('');
        // console.log('RTRenderer attributeChangedCallback >>', newHTML);
        this.initialHTML = newHTML;
        this.renderer();
      }
    }

    static get observedAttributes() {
      // console.log('RTRenderer observedAttributes >>');
      return ['c', 'l', 'slim-width', 'encoded-content'];
    }

    updateStyle(elem) {
      const shadow = elem.shadowRoot;
      shadow.querySelector('style').textContent = `
        div {
          width: ${elem.getAttribute('l')}px;
          height: ${elem.getAttribute('l')}px;
          background-color: ${elem.getAttribute('c')};
        }
      `;
    }

    renderer() {
      // console.log('RENDERER >>', [this.wrapper, this.initialHTML]);
      // Create a shadow root
      if (!this.shadowRoot) {
        this.attachShadow({mode: 'open'}); // sets and returns 'this.shadowRoot'
        const wrapper = document.createElement('div');
        wrapper.setAttribute('class', 'wrapper ck-content');
        const style = document.createElement('style');
        style.textContent = this.innerStyles;
        // CSS truncated for brevity
        wrapper.textContent = '';
        // attach the created elements to the shadow DOM
        this.shadowRoot.append(style, wrapper);
        this.wrapper = wrapper;
      }
      if (this.innerHTML.length === 0) this.innerHTML = this.initialHTML;
      if (this.slimWidth) this.wrapper.classList.add('slim-width');
      else this.wrapper.classList.remove('slim-width');
    }

    set innerHTML(html) {
      // console.log('HTML >>', [html, this.wrapper, this.initialHTML]);
      if (this.wrapper) {
        super.innerHTML = '';
        let renderHTML = this.initialHTML;
        renderHTML = renderHTML.replaceAll(
          `<div> </div>`,
          `<div class="__rt_only_nbsp"> </div>`,
        );
        renderHTML = renderHTML.replaceAll(
          `<p> </p>`,
          `<p class="__rt_only_nbsp"> </p>`,
        );
        this.wrapper.innerHTML = renderHTML;
        this.runJS();
      }
    }

    get innerHTML() {
      return this.wrapper ? this.wrapper.innerHTML : '';
    }

    get innerText() {
      return this.wrapper ? this.wrapper.innerText : '';
    }

    set innerText(text) {
      // do nothing
    }

    get innerStyles() {
      return tinymceStyles + ckEditorStyles + shadowDomStyles + modifyOldStyles;
    }

    // js for the content behaviors
    runJS() {
      [...this.wrapper.querySelectorAll('img')].forEach((v) => {
        var src = v.getAttribute('src');
        if (src.search(fileBaseUrl) === 0)
          urlContentToDataUri(src).then((dataURI) => {
            // console.log('dataURI >>', dataURI);
            v.setAttribute('data-src', src);
            v.setAttribute('src', dataURI);
          });
      });
      // marquee play / pause
      [...this.wrapper.querySelectorAll('marquee')].forEach((v) => {
        v.setAttribute('onpointerleave', 'this.start()');
        v.setAttribute('onpointerenter', 'this.stop()');
      });
    }
  }

  customElements.define('rt-renderer', RichTextRenderer);

  class PlainTextRenderer extends RichTextRenderer {
    constructor() {
      super();
      this.lineClamp = 0;
    }

    attributeChangedCallback(name, oldValue, newValue) {
      if (name === 'line-clamp') {
        this.lineClamp = parseInt(newValue) || 0;
        this.renderer();
      } else {
        super.attributeChangedCallback(name, oldValue, newValue);
      }
    }

    static get observedAttributes() {
      // console.log('RTRenderer observedAttributes >>');
      return ['c', 'l', 'slim-width', 'encoded-content', 'line-clamp'];
    }

    renderer() {
      super.renderer();
      if (this.lineClamp > 0) {
        this.wrapper.style.display = '-webkit-box';
        this.wrapper.style.webkitBoxOrient = 'vertical';
        this.wrapper.style.webkitLineClamp = `${this.lineClamp}`;
        this.wrapper.style.lineClamp = `${this.lineClamp}`;
        this.wrapper.style.overflow = 'hidden';
        this.wrapper.style.textOverflow = 'ellipsis';
      } else {
        this.wrapper.removeAttribute('style');
      }
    }

    set innerHTML(html) {
      // console.log('HTML >>', [html, this.wrapper, this.initialHTML]);
      if (this.wrapper) {
        super.innerHTML = '';
        let renderHTML = this.initialHTML;
        renderHTML = renderHTML.replaceAll(
          `<div> </div>`,
          `<div class="__rt_only_nbsp"> </div>`,
        );
        renderHTML = renderHTML.replaceAll(
          `<p> </p>`,
          `<p class="__rt_only_nbsp"> </p>`,
        );
        const temp = document.createElement('div');
        temp.innerHTML = renderHTML.replaceAll('</', '\n</');
        this.wrapper.innerHTML = `<div>${temp.innerText.split(/\n[\n\s]*/).join('</div><div>')}</div>`;
        this.runJS();
      }
    }

    get innerStyles() {
      return '';
    }

    get innerHTML() {
      return this.wrapper ? this.wrapper.innerHTML : '';
    }
  }

  customElements.define('pt-renderer', PlainTextRenderer);

  window.encodeRT = (txt) => {
    let temp = '' + txt;
    const chunks = [],
      size = 10240;
    while (temp.length > size) {
      chunks.push(temp.substring(0, size));
      temp = temp.slice(size);
    }
    chunks.push(temp);
    return chunks
      .map((c) => btoa(String.fromCharCode(...new TextEncoder().encode(c))))
      .join(';');
  };

  let fontFaceStylesInjected = false;
  window.injectFontFacesRT = () => {
    if (fontFaceStylesInjected) return;
    const styleTag = document.createElement('style');
    styleTag.innerHTML = `
    @font-face {
        font-family: 'BenSenHandwriting';
        font-style: normal;
        font-weight: 400;
        src: url(/site-assets/fonts/BenSenHandwriting.ttf) format('truetype');
    }
    @font-face {
        font-family: 'Roboto-Regular';
        font-style: normal;
        font-weight: 400;
        src: url(/site-assets/fonts/Roboto-Regular.ttf) format('truetype');
    }
    @font-face {
        font-family: 'Kalpurush';
        font-style: normal;
        font-weight: 400;
        src: url(/site-assets/fonts/kalpurush.ttf) format('truetype');
    }
    @font-face {
        font-family: 'kalpurushregular';
        font-style: normal;
        font-weight: 400;
        src: url(/site-assets/fonts/kalpurush.ttf) format('truetype');
    }`;
    document.head.appendChild(styleTag);
    fontFaceStylesInjected = true;
  };

  document
    .querySelectorAll(
      '[data-section_type="right"] rt-renderer, [data-section_type="left"] rt-renderer',
    )
    .forEach((el) => {
      el.setAttribute('slim-width', '');
    });

  document.querySelectorAll('img').forEach((el) => {
    el.classList.add('image-loading');
    el.onload = () => {
      el.classList.remove('image-loading');
    };
    el.onerror = () => {
      el.classList.remove('image-loading');
      el.classList.add('image-loading-error');
    };
    el.src = el.getAttribute('src');
  });

  if (/npf.test$/.test(window.location.host) && false) {
    let tryCount = 0;
    let rel = false;
    setInterval(() => {
      fetch(`/ajax/get/division/list`)
        .then((result) => {
          tryCount = 0;
        })
        .catch((err) => {
          if (!rel) rel = '-' + window.location.reload();
        });
      tryCount++;
      if (tryCount > 3 && !rel) rel = '-' + window.location.reload();
    }, 50);
  }
})();

// Track all sticky widgets
const stickyWidgets = [];
let rafId = null;

// Update sticky positions efficiently
function updateStickyPositions() {
  let currentTop = 0;
  stickyWidgets.forEach(function (item) {
    if (item.isSticky) {
      const height = item.widget.offsetHeight;
      item.widget.style.top = currentTop + 'px';
      currentTop += height;
    }
  });
}

// Handle scroll with requestAnimationFrame for smooth performance
function handleScroll() {
  if (rafId) return; // Already scheduled

  rafId = requestAnimationFrame(function () {
    rafId = null;
    const scrollY = window.pageYOffset || window.scrollY;

    stickyWidgets.forEach(function (item) {
      const widget = item.widget;
      const shouldBeSticky = scrollY >= item.originalTop;

      if (shouldBeSticky && !item.isSticky) {
        // Become sticky
        const rect = widget.getBoundingClientRect();
        widget.style.position = 'fixed';
        widget.style.width = rect.width + 'px';
        widget.style.boxSizing = 'border-box';
        widget.style.zIndex = '1000';

        item.isSticky = true;

        if (!item.spacer) {
          const spacer = document.createElement('div');
          spacer.className = 'sticky-spacer';
          spacer.style.height = widget.offsetHeight + 'px';
          widget.parentNode.insertBefore(spacer, widget.nextSibling);
          item.spacer = spacer;
        }
      } else if (!shouldBeSticky && item.isSticky) {
        // Remove sticky
        widget.style.position = '';
        widget.style.top = '';
        widget.style.width = '';
        widget.style.boxSizing = '';
        widget.style.zIndex = '';

        item.isSticky = false;

        if (item.spacer && item.spacer.parentNode) {
          item.spacer.remove();
          item.spacer = null;
        }
      }
    });

    // Update positions only if there are sticky items
    if (
      stickyWidgets.some(function (item) {
        return item.isSticky;
      })
    ) {
      updateStickyPositions();
    }
  });
}

function initSticky(elements) {
  const markers =
    typeof elements === 'object' && elements?.length ? elements : [];

  if (!markers.length) return;

  // Capture all original positions in one pass
  markers.forEach(function (marker) {
    const rect = marker.getBoundingClientRect();
    stickyWidgets.push({
      widget: marker,
      originalTop: rect.top + window.pageYOffset,
      isSticky: false,
      spacer: null,
    });
  });

  // Handle resize - recalculate positions for all states
  let resizeTimer;
  function handleResize() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      // Cancel any pending scroll animation
      if (rafId) {
        cancelAnimationFrame(rafId);
        rafId = null;
      }

      // First, remove all sticky states temporarily to get accurate positions
      stickyWidgets.forEach(function (item) {
        if (item.isSticky) {
          item.widget.style.position = '';
          item.widget.style.top = '';
          item.widget.style.width = '';
          item.widget.style.boxSizing = '';
          item.widget.style.zIndex = '';

          if (item.spacer && item.spacer.parentNode) {
            item.spacer.remove();
            item.spacer = null;
          }

          item.isSticky = false;
        }
      });

      // Use requestAnimationFrame to ensure browser has reflowed
      requestAnimationFrame(function () {
        // Recalculate all original positions
        stickyWidgets.forEach(function (item) {
          const rect = item.widget.getBoundingClientRect();
          item.originalTop = rect.top + window.pageYOffset;
        });

        // Reapply sticky states based on current scroll position
        handleScroll();
      });
    }, 10);
  }

  // Initial check
  handleScroll();

  // Event listeners
  window.addEventListener('scroll', handleScroll, {passive: true});
  window.addEventListener('resize', handleResize, {passive: true});
}

window.createStickyElements = (elements) => {
  initSticky(elements);
};
