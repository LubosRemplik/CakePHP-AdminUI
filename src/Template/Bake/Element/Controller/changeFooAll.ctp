
    /**
     * changeFooAll method
     *
     * @return mixed
     */
    public function changeFooAll()
    {
        if ($this->request->is('post')) {
            $fooIds = $this->request->data['foos'];
            $<%= $singularName %>Ids = [];
            foreach ($this->request->data['selected'] as $<%= $singularName %>Id => $selected) {
                if ($selected) {
                    $<%= $singularName %>Ids[] = $<%= $singularName %>Id;
                }
            }
            if ($<%= $singularName %>Ids && $fooIds) {
                // delete query
                $query = $this->Foos<%= $currentModelName %>->query();
                $query
                    ->delete()
                    ->where(['<%= $singularName %>_id IN' => $<%= $singularName %>Ids]);
                $query->execute();
                // insert query
                $query = $this->Foos<%= $currentModelName %>->query();
                foreach ($<%= $singularName %>Ids as $<%= $singularName %>Id) {
                    foreach ($fooIds as $fooId) {
                        $query
                            ->insert(['<%= $singularName %>_id', 'foo_id'])
                            ->values(['<%= $singularName %>_id' => $<%= $singularName %>Id, 'foo_id' => $fooId]);
                    }
                }
                $query->execute();
                // unset request data and flash message
                $this->request->data = [];
                $this->Flash->success(__('The records have been updated.'));
            }
        }
        if ($this->request->is('ajax')) {
            return $this->index();
        }
        return $this->redirect(['action' => 'index']);
    }
