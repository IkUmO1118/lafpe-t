import { useMutation } from "@tanstack/react-query";
import { useNavigate } from "react-router-dom";
import { useSetSession as SetSession } from "../../hooks/useSession";
import { updateDiganosis as updateDiagnosisApi } from "../../services/apiDiagnosis";
import toast from "react-hot-toast";

export function useUpdateKarte() {
  const navigate = useNavigate();

  const { mutate: updateKarte, isPending: isUpdating } = useMutation({
    mutationFn: updateDiagnosisApi,
    onSuccess: (data) => {
      SetSession({
        key: "karte",
        value: `${JSON.stringify(data.diagnosis)}`,
      });
      toast.success("診断結果を更新しました");
      navigate("/result");
    },
    onError: (error: Error) => {
      const errorMessage = error.message || "診断の更新に失敗しました";
      toast.error(errorMessage);
    },
  });

  return { updateKarte, isUpdating };
}
