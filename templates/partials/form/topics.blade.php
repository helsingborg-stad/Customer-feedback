
    <!-- Topic segment -->
    <div id="customer-feedback-topics" class="customer-feedback-topics feedback-answer-no u-margin__top--4">

        <label class="c-typography c-typography__variant--h3">
            <?php echo $topicLabel; ?>
        </label>

        <p class="c-typography typography__variant--small u-margin__top--0">
            <?php echo $addComment; ?>
        </p>

        @foreach ($topics as $key => $topic)
          @option([
            'id' => $key,
            'type' => 'radio',
            'attributeList' => [
              'name' => 'customer-feedback-comment-topic',
              'value' => $topic->id,
              'topic-description' => $topic->description,
              'feedback-capability' => $topic->feedback_capability
            ],
            'label' => $topic->name
          ])
          @endoption
        @endforeach

    </div>
