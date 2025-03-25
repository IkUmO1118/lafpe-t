import { useMutation } from "@tanstack/react-query";
import { useNavigate } from "react-router-dom";
import { useSetSession as SetSession } from "../../hooks/useSession";
import { postDiagnosis as postDiagnosisApi } from "../../services/apiDiagnosis";
import toast from "react-hot-toast";

export function useCreateKarte() {
  const navigate = useNavigate();

  const { mutate: createKarte, isPending: isCreating } = useMutation({
    mutationFn: postDiagnosisApi,
    onSuccess: (data) => {
      SetSession({
        key: "karte",
        value: `${JSON.stringify(data.diagnosis)}`,
      });
      toast.success("診断を完了しました");
      navigate("/result");
    },
    onError: (err) => {
      toast.error(err.message);
      console.error(err.message);
    },
  });

  return { createKarte, isCreating };
}
