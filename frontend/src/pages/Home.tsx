import CallToAction from "../features/home/CallToAction";
import EvaluationBasis from "../features/home/EvaluationBasis";
import EvaluationImage from "../features/home/EvaluationImage";
import Hero from "../features/home/Hero";
import ToolBanner from "../features/home/ToolBanner";

function Home() {
  return (
    <section className="flex w-full flex-col">
      <Hero />
      <ToolBanner />
      <EvaluationImage />
      <EvaluationBasis />
      <CallToAction />
    </section>
  );
}

export default Home;
