import FeedbackHeader from "../features/feedback/FeedbackHeader";
import FeedbackForm from "../features/feedback/FeedbackForm";

function Feedback() {
  return (
    <section className="my-16 grid h-full grid-cols-2 place-items-stretch">
      <FeedbackHeader />
      <FeedbackForm />
    </section>
  );
}

export default Feedback;
