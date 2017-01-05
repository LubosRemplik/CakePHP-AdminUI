
    /**
     * deleteAll method
     *
     * @return mixed
     */
    public function deleteAll()
    {
        if ($this->request->is('post')) {
            $ids = [];
            foreach ($this->request->data['selected'] as $id => $selected) {
                if ($selected) {
                    $ids[] = $id;
                }
            }
            if ($ids) {
                $this-><%= $currentModelName %>->query()
                    ->delete()
                    ->where(['id IN' => $ids])
                    ->execute();
                // Flash message
                $this->Flash->success(__('The records have been deleted.'));
            }
        }
        if ($this->request->is('ajax')) {
            return $this->index();
        }
        return $this->redirect(['action' => 'index']);
    }

