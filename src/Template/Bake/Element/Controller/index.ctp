
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $query = $this-><%= $currentModelName %>->find('search', ['search' => $this->request->query]);
        $<%= $pluralName %> = $this->paginate($query);
        $isSearch = $this-><%= $currentModelName %>->isSearch();

        $this->set(compact('<%= $pluralName %>', 'isSearch'));
        $this->set('_serialize', ['<%= $pluralName %>']);

        if ($this->request->is('ajax')) {
            return $this->render('index', false);
        }
    }
