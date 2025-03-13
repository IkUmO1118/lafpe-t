import { useRef } from "react";
import CallToAction from "../features/home/CallToAction";
import EvaluationBasis from "../features/home/EvaluationBasis";
import EvaluationImage from "../features/home/EvaluationImage";
import Hero from "../features/home/Hero";
import ToolBanner from "../features/home/ToolBanner";

function Home() {
  const evaluationImageRef = useRef<HTMLDivElement>(null);

  const scrollToEvaluation = () => {
    evaluationImageRef.current?.scrollIntoView({
      behavior: "smooth",
      block: "start",
    });
  };

  return (
    <section className="flex w-full flex-col">
      <Hero scrollToEvaluation={scrollToEvaluation} />
      <ToolBanner />
      <EvaluationImage ref={evaluationImageRef} />
      <EvaluationBasis />
      <CallToAction />
    </section>
  );
}

export default Home;
