
    /**
     * statusAll method
     *
     * @param mixed $status
     * @return mixed
     */
    public function statusAll($status = null)
    {
        if ($this->request->is('post')) {
            $ids = [];
            foreach ($this->request->data['selected'] as $id => $selected) {
                if ($selected) {
                    $ids[] = $id;
                }
            }
            if (isset($this->request->data['status'])) {
                $status = $this->request->data['status'];
            }
            if ($ids && $status !== null) {
                $this-><%= $currentModelName %>->query()
                    ->update()
                    ->set(['status' => $status])
                    ->where(['id IN' => $ids])
                    ->execute();
                // Flash message
                $this->Flash->success(__('The records have been updated.'));
            }
        }
        if ($this->request->is('ajax')) {
            return $this->index();
        }
        return $this->redirect(['action' => 'index']);
    }
